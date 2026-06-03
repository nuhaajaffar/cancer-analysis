# Cancer Analysis System

A full-stack healthcare management platform that integrates role-based clinical workflows with AI-assisted brain tumour MRI classification.

The system enables healthcare professionals to manage patients, medical scans, radiology reports, appointments, notifications and audit logs within a secure environment. It also incorporates a deep learning model trained on MRI brain tumour images to provide automated scan analysis and report generation.

The project combines software engineering, database management, healthcare workflow design and machine learning into a single integrated application.

## Project Overview

The aim of this project is to develop a healthcare-focused cancer analysis platform that supports collaboration between doctors, radiographers, radiologists, administrators and patients while demonstrating practical AI integration within a medical environment.

The system provides:

* Patient record management
* Medical scan uploads and storage
* Radiology report management
* Doctor review workflows
* Appointment scheduling and tracking
* Notification management
* Audit logging and traceability
* AI-assisted MRI scan analysis
* Automated PDF report generation

The AI component uses a ResNet18 convolutional neural network trained on brain tumour MRI images to classify scans into four categories:

* Glioma
* Meningioma
* Pituitary Tumour
* No Tumour

Prediction results, confidence scores and model metadata are automatically stored within the healthcare system and included in generated reports.

## Features

### Authentication and Security

* User authentication
* Session management
* Role-based access control (RBAC)
* Route protection
* File access restrictions
* Audit logging

### Patient Management

* Patient profile management
* Medical information tracking
* Assigned healthcare staff
* Search and filtering functionality

### Scan Management

* Medical scan uploads
* Scan downloads
* Scan deletion controls
* AI-assisted scan analysis
* Scan history tracking

### Report Management

* Radiology report uploads
* Report downloads
* Report deletion controls
* Doctor review workflows
* Report history management

### Appointment Management

* Appointment creation
* Appointment editing
* Appointment cancellation
* Appointment status tracking

### Notifications

* Scan upload notifications
* Report upload notifications
* User-specific notification dashboard

### Audit Logging

* Scan uploads
* Report uploads
* Report deletions
* Scan deletions
* Doctor review actions
* Patient profile updates

### Artificial Intelligence

* Brain tumour MRI classification
* ResNet18 deep learning model
* Confidence score generation
* Automated PDF report generation
* Model metadata tracking
* Evaluation reporting

## Screenshots

### Admin Dashboard

[Insert Screenshot]

### Patient Details Page

[Insert Screenshot]

### AI Analysis Results

[Insert Screenshot]

### Audit Logs

[Insert Screenshot]

### Generated PDF Report

[Insert Screenshot]

## User Roles

The system supports five healthcare roles.

### Admin

* Full system access
* Manage patients
* Manage scans and reports
* View audit logs
* Monitor system activity

### Doctor

* View assigned patients
* Create doctor reviews
* Manage appointments
* View AI analysis results

### Radiographer

* Upload medical scans
* Manage scan records
* View assigned patients

### Radiologist

* Upload radiology reports
* Review patient scans
* Manage report records

### Patient

* View personal records
* View appointments
* Download reports
* Access AI analysis results

## AI Model

The AI module performs automated brain tumour MRI classification.

### Model Architecture

* Architecture: ResNet18
* Framework: PyTorch
* Input Size: 224 × 224 RGB Images

### Output Classes

* Glioma
* Meningioma
* Pituitary Tumour
* No Tumour

### Stored Analysis Metadata

Each analysis stores:

* Predicted class
* Confidence score
* Model name
* Model evaluation accuracy
* Analysis timestamp

## Dataset

The model was trained using the Brain Tumor MRI Dataset from Kaggle.

Dataset Source:

https://www.kaggle.com/datasets/masoudnickparvar/brain-tumor-mri-dataset

### Dataset Classes

* Glioma
* Meningioma
* Pituitary Tumour
* No Tumour

### Dataset Characteristics

* MRI brain scans
* JPEG image format
* Pre-organised training and testing sets
* Multi-class classification problem

## System Architecture

```text
MRI Scan Upload
        │
        ▼
Laravel Application
        │
        ▼
Python AI Module
        │
        ▼
ResNet18 Model
        │
        ▼
Prediction + Confidence
        │
        ▼
Database Storage
        │
        ▼
PDF Report Generation
```

## Project Structure

```text
cancer-analysis/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── PatientController.php
│   │   │   ├── ScanController.php
│   │   │   ├── ReportController.php
│   │   │   ├── AIController.php
│   │   │   └── ...
│   │   │
│   │   └── Middleware/
│   │       └── RoleMiddleware.php
│   │
│   └── Models/
│       ├── User.php
│       ├── PatientScan.php
│       ├── PatientReport.php
│       ├── Appointment.php
│       ├── AuditLog.php
│       └── AppNotification.php
│
├── database/
│   ├── migrations/
│   └── seeders/
│
├── resources/
│   └── views/
│
├── storage/
│       └── public/
│           ├── scans/
│           └── reports/
│
├── ai_int/
│   ├── dataset/
│   ├── model/
│   ├── evaluation/
│   ├── train_model.py
│   ├── evaluate_model.py
│   ├── analyse_scan.py
│   └── generate_report.py
│
├── routes/
│   └── web.php
│
└── README.md
```

## Tech Stack

### Backend

* Laravel 12
* PHP 8.2
* MySQL

### Frontend

* Blade Templates
* HTML
* CSS
* JavaScript

### Artificial Intelligence

* Python 3
* PyTorch
* TorchVision
* Pillow
* Scikit-learn
* Matplotlib

### Reporting

* ReportLab

## Demo Accounts

| Role         | Email                                                       | Password    |
| ------------ | ----------------------------------------------------------- | ----------- |
| Admin        | [admin@example.com](mailto:admin@example.com)               | password123 |
| Doctor       | [doctor@example.com](mailto:doctor@example.com)             | password123 |
| Radiographer | [radiographer@example.com](mailto:radiographer@example.com) | password123 |
| Radiologist  | [radiologist@example.com](mailto:radiologist@example.com)   | password123 |
| Patient      | [patient@example.com](mailto:patient@example.com)           | password123 |

## Setup Instructions

### Clone Repository

```bash
git clone https://github.com/nuhaajaffar/cancer-analysis.git
cd cancer-analysis
```

### Install Dependencies

```bash
composer install
npm install
```

### Configure Environment

```bash
cp .env.example .env
php artisan key:generate
```

### Database Setup

```bash
php artisan migrate --seed
```

### Start Application

```bash
php artisan serve
```

### Train AI Model

```bash
py ai_int/train_model.py
```

### Evaluate AI Model

```bash
py ai_int/evaluate_model.py
```

## Evaluation Results

### Overall Performance

* Test Accuracy: 92.50%

### Class Performance

| Class      | Precision | Recall | F1-Score |
| ---------- | --------- | ------ | -------- |
| Glioma     | 0.94      | 0.79   | 0.86     |
| Meningioma | 0.86      | 0.94   | 0.89     |
| No Tumour  | 0.95      | 0.98   | 0.97     |
| Pituitary  | 0.96      | 0.99   | 0.98     |

### Generated Evaluation Files

* Confusion Matrix
* Classification Report
* Evaluation Summary

## Output Files

### Trained Model

```text
ai_int/model/resnet18_brain_tumor.pth
```

### Evaluation Results

```text
ai_int/evaluation/
├── confusion_matrix.png
└── evaluation_report.txt
```

### Generated Reports

```text
storage/app/public/ai_reports/
```

## Limitations

* The AI model was trained using publicly available brain MRI datasets.
* The current model supports only brain tumour classification.
* The system currently accepts image-based MRI scans rather than DICOM files.
* The AI module is intended as a decision-support prototype and not a clinical diagnostic tool.
* Model performance may vary when applied to different datasets or clinical environments.
* Real-world deployment would require extensive validation, regulatory approval and specialist oversight.

## Future Improvements

* Vision Transformer (ViT) implementation
* Explainable AI using Grad-CAM
* DICOM image support
* Multi-cancer classification
* Cloud deployment
* Email notifications
* Advanced analytics dashboard
* Ensemble learning approaches

## Important Note

This project was developed for educational and research purposes.

The AI component is intended as a proof-of-concept system demonstrating the integration of machine learning into a healthcare workflow. It should not be used for real clinical diagnosis or treatment decisions. Final interpretation of medical images should always be performed by qualified healthcare professionals.
