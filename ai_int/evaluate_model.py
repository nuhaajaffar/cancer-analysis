import matplotlib.pyplot as plt
import torch
import torch.nn as nn
from pathlib import Path
from sklearn.metrics import classification_report, confusion_matrix, ConfusionMatrixDisplay
from torch.utils.data import DataLoader
from torchvision import datasets, models, transforms

BASE_DIR = Path(__file__).resolve().parent
DATASET_DIR = BASE_DIR / "dataset"
TEST_DIR = DATASET_DIR / "Testing"
MODEL_PATH = BASE_DIR / "model" / "resnet18_brain_tumor.pth"
OUTPUT_DIR = BASE_DIR / "evaluation"
OUTPUT_DIR.mkdir(exist_ok = True)

BATCH_SIZE = 16

device = torch.device("cuda" if torch.cuda.is_available() else "cpu")

transform = transforms.Compose([
    transforms.Resize((224, 224)),
    transforms.ToTensor(),
    transforms.Normalize(
        mean = [0.485, 0.456, 0.406],
        std = [0.229, 0.224, 0.225]
    )
])

test_dataset = datasets.ImageFolder(TEST_DIR, transform = transform)
test_loader = DataLoader(test_dataset, batch_size = BATCH_SIZE, shuffle = False)

checkpoint = torch.load(MODEL_PATH, map_location = device)
class_names = checkpoint["class_names"]
num_classes = len(class_names)

model = models.resnet18(weights = None)
model.fc = nn.Linear(model.fc.in_features, num_classes)
model.load_state_dict(checkpoint["model_state_dict"])
model.to(device)
model.eval()

all_labels = []
all_predictions = []

with torch.no_grad():
    for images, labels in test_loader:
        images = images.to(device)
        labels = labels.to(device)

        outputs = model(images)
        _, predictions = torch.max(outputs, 1)

        all_labels.extend(labels.cpu().numpy())
        all_predictions.extend(predictions.cpu().numpy())

correct = sum(
    true_label == predicted_label
    for true_label, predicted_label in zip(all_labels, all_predictions)
)

accuracy = correct / len(all_labels) * 100

print("\nModel Evaluation Results")
print("------------------------")
print(f"Test Accuracy: {accuracy:.2f}%")
print("\nClassification Report:")
print(classification_report(
    all_labels,
    all_predictions,
    target_names = class_names
))

cm = confusion_matrix(all_labels, all_predictions)

display = ConfusionMatrixDisplay(
    confusion_matrix = cm,
    display_labels = class_names
)

display.plot(cmap = "Blues", xticks_rotation = 45)
plt.title("Brain Tumor MRI Classification - Confusion Matrix")
plt.tight_layout()

output_path = OUTPUT_DIR / "confusion_matrix.png"
plt.savefig(output_path)
plt.close()

print(f"\nConfusion matrix saved to: {output_path}")