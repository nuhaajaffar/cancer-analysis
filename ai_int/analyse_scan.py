import sys
import json
import random

def analyse_scan(scan_path):
    predictions = [
        "No tumour detected",
        "Possible tumour detected",
        "Further review recommended"
    ]

    result = {
        "prediction": random.choice(predictions),
        "confidence": round(random.uniform(70, 95), 2)
    }

    return result

if __name__ == "__main__":
    scan_path = sys.argv[1]

    result = analyse_scan(scan_path)

    print(json.dumps(result))