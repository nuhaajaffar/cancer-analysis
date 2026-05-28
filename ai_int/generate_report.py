import sys
from reportlab.lib.pagesizes import A4
from reportlab.pdfgen import canvas
from datetime import datetime

def generate_pdf(output_path, patient_name, prediction, confidence):
    c = canvas.Canvas(output_path, pagesize = A4)

    c.setFont("Helvetica-Bold", 18)
    c.drawString(50, 800, "Cancer Analysis AI Report")

    c.setFont("Helvetica", 12)
    c.drawString(50, 760, f"Patient Name: {patient_name}")
    c.drawString(50, 735, f"Prediction: {prediction}")
    c.drawString(50, 710, f"Confidence: {confidence}%")
    c.drawString(50, 685, f"Generated At: {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}")

    c.drawString(50, 640, "Note:")
    c.drawString(50, 620, "This AI result is for demonstration purposes only.")

    c.save()

if __name__ == "__main__":
    output_path = sys.argv[1]
    patient_name = sys.argv[2]
    prediction = sys.argv[3]
    confidence = sys.argv[4]

    generate_pdf(output_path, patient_name, prediction, confidence)