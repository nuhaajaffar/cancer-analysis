import sys
import json
import torch
import torch.nn as nn
from torchvision import models, transforms
from PIL import Image
from pathlib import Path

BASE_DIR = Path(__file__).resolve().parent
MODEL_PATH = BASE_DIR / "model" / "resnet18_brain_tumor.pth"

device = torch.device("cuda" if torch.cuda.is_available() else "cpu")

transform = transforms.Compose([
    transforms.Resize((224, 224)),
    transforms.ToTensor(),
    transforms.Normalize(
        mean = [0.485, 0.456, 0.406],
        std = [0.229, 0.224, 0.225]
    )
])

def load_model():
    checkpoint = torch.load(MODEL_PATH, map_location = device)

    class_names = checkpoint["class_names"]
    num_classes = len(class_names)

    model = models.resnet18(weights = None)
    model.fc = nn.Linear(model.fc.in_features, num_classes)

    model.load_state_dict(checkpoint["model_state_dict"])
    model.to(device)
    model.eval()

    return model, class_names

def predict_image(image_path):
    model, class_names = load_model()

    image = Image.open(image_path).convert("RGB")
    image = transform(image).unsqueeze(0).to(device)

    with torch.no_grad():
        outputs = model(image)
        probabilities = torch.softmax(outputs, dim = 1)

        confidence, predicted_index = torch.max(probabilities, 1)

    prediction = class_names[predicted_index.item()]
    confidence_score = round(confidence.item() * 100, 2)

    return {
        "prediction": prediction,
        "confidence": confidence_score
    }

if __name__ == "__main__":
    try:
        image_path = sys.argv[1]

        result = predict_image(image_path)

        print(json.dumps(result))

    except Exception as e:
        print(json.dumps({
            "error": str(e)
        }))