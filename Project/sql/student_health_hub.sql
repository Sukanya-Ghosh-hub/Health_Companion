-- Database: student_health_hub
CREATE DATABASE IF NOT EXISTS student_health_hub;
USE student_health_hub;

-- Admin Table
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Students Table
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(20) NOT NULL UNIQUE,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    date_of_birth DATE,
    gender ENUM('Male', 'Female', 'Other'),
    blood_type VARCHAR(5),
    allergies TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Appointments Table
CREATE TABLE IF NOT EXISTS appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    service_type VARCHAR(50) NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    notes TEXT,
    status ENUM('scheduled', 'completed', 'cancelled', 'no-show') DEFAULT 'scheduled',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);

-- Contact Messages Table
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Health Records Table
CREATE TABLE IF NOT EXISTS health_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    record_type VARCHAR(50) NOT NULL,
    description TEXT,
    file_path VARCHAR(255),
    date_recorded DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);

-- Insert Sample Admin (password: admin123)
INSERT INTO admins (username, password, full_name, email) 
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin User', 'admin@healthhub.edu');

-- Insert Sample Students
INSERT INTO students (student_id, first_name, last_name, email, phone, date_of_birth, gender, blood_type, allergies)
VALUES 
('ST1001', 'John', 'Doe', 'john.doe@university.edu', '555-0101', '2000-05-15', 'Male', 'O+', 'Peanuts'),
('ST1002', 'Jane', 'Smith', 'jane.smith@university.edu', '555-0102', '1999-08-22', 'Female', 'A-', 'Penicillin'),
('ST1003', 'Alex', 'Johnson', 'alex.johnson@university.edu', '555-0103', '2001-03-10', 'Other', 'B+', NULL);

-- Insert Sample Appointments
INSERT INTO appointments (student_id, service_type, appointment_date, appointment_time, notes, status)
VALUES 
(1, 'General Consultation', '2023-06-25', '10:30:00', 'Annual checkup', 'scheduled'),
(2, 'Mental Health', '2023-06-26', '14:00:00', 'Therapy session follow-up', 'scheduled'),
(3, 'Immunization', '2023-06-27', '09:15:00', 'Flu vaccine', 'completed');

-- Insert Sample Contact Messages
INSERT INTO contact_messages (name, email, subject, message)
VALUES 
('Sarah Williams', 'sarah@email.com', 'Question about services', 'What mental health services do you offer?'),
('Michael Brown', 'michael@email.com', 'Appointment issue', 'I need to reschedule my appointment');