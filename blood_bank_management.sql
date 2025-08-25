/*DATABASE*/

DROP DATABASE IF EXISTS blood_bank_management;
CREATE DATABASE blood_bank_management;
USE blood_bank_management;

CREATE TABLE donors (
    donor_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(20) NOT NULL,
    date_of_birth DATE NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    blood_type ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-') NOT NULL,
    address TEXT,
    city VARCHAR(100),
    last_donation_date DATE,
    health_conditions TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE hospitals (
    hospital_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    address TEXT NOT NULL,
    city VARCHAR(100) NOT NULL,
    contact_person VARCHAR(100),
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE staff (
    staff_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    role ENUM('Admin', 'Nurse', 'Technician', 'Coordinator') NOT NULL,
    shift ENUM('Morning', 'Evening', 'Night') NOT NULL,
    hire_date DATE NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE donations (
    donation_id INT AUTO_INCREMENT PRIMARY KEY,
    donor_id INT NOT NULL,
    staff_id INT NOT NULL,
    donation_date DATE NOT NULL,
    donation_time TIME,
    blood_type ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-') NOT NULL,
    volume_ml INT NOT NULL CHECK (volume_ml BETWEEN 450 AND 500),
    test_results ENUM('Pending', 'Passed', 'Failed') DEFAULT 'Pending',
    notes TEXT,
    FOREIGN KEY (donor_id) REFERENCES donors(donor_id),
    FOREIGN KEY (staff_id) REFERENCES staff(staff_id)
);

CREATE TABLE blood_inventory (
    inventory_id INT AUTO_INCREMENT PRIMARY KEY,
    donation_id INT NOT NULL,
    blood_type ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-') NOT NULL,
    volume_ml INT NOT NULL,
    received_date DATE NOT NULL,
    expiration_date DATE NOT NULL,
    storage_location VARCHAR(100),
    status ENUM('Available', 'Reserved', 'Used', 'Expired') DEFAULT 'Available',
    FOREIGN KEY (donation_id) REFERENCES donations(donation_id)
);

CREATE TABLE requests (
    request_id INT AUTO_INCREMENT PRIMARY KEY,
    hospital_id INT NOT NULL,
    blood_type ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-') NOT NULL,
    quantity_units INT NOT NULL,
    urgency ENUM('Low', 'Medium', 'High', 'Critical') DEFAULT 'Medium',
    status ENUM('Pending', 'Approved', 'Fulfilled', 'Rejected') DEFAULT 'Pending',
    request_date DATE NOT NULL,
    needed_by_date DATE,
    notes TEXT,
    fulfilled_date DATE,
    FOREIGN KEY (hospital_id) REFERENCES hospitals(hospital_id)
);

CREATE TABLE activity_log (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    staff_id INT,
    activity_type VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    table_affected VARCHAR(50),
    record_id INT,
    ip_address VARCHAR(45),
    log_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (staff_id) REFERENCES staff(staff_id)
);

-- Insert sample data
INSERT INTO donors (first_name, last_name, email, phone, date_of_birth, gender, blood_type, address, city) VALUES
('Pranto', 'Banik', 'prantobanik51@email.com', '01881709817', '2002-12-07', 'Male', 'O+', 'Jhalakathi', 'Barishal'),
('Jane', 'Smith', 'jane.smith@email.com', '234-567-8901', '1985-08-22', 'Female', 'A-', '456 Oak Ave', 'Shelbyville'),
('Robert', 'Johnson', 'robert.j@email.com', '345-678-9012', '1992-11-03', 'Male', 'B+', '789 Pine Rd', 'Capital City');

INSERT INTO hospitals (name, address, city, contact_person, phone, email) VALUES
('City General Hospital', '100 Hospital Drive', 'Springfield', 'Dr. Emily Wilson', '111-222-3333', 'info@citygeneral.org'),
('County Medical Center', '200 Health Avenue', 'Shelbyville', 'Dr. Michael Chen', '444-555-6666', 'admin@countymedical.org');

INSERT INTO staff (first_name, last_name, email, phone, role, shift, hire_date) VALUES
('Sarah', 'Miller', 'sarah.m@bloodbank.org', '555-123-4567', 'Nurse', 'Morning', '2020-03-10'),
('David', 'Brown', 'david.b@bloodbank.org', '555-234-5678', 'Technician', 'Evening', '2021-06-15'),
('Lisa', 'Taylor', 'lisa.t@bloodbank.org', '555-345-6789', 'Coordinator', 'Morning', '2019-01-20');

INSERT INTO donations (donor_id, staff_id, donation_date, donation_time, blood_type, volume_ml, test_results) VALUES
(1, 1, '2023-10-05', '09:30:00', 'O+', 450, 'Passed'),
(2, 2, '2023-10-06', '14:15:00', 'A-', 480, 'Passed'),
(3, 1, '2023-10-07', '10:45:00', 'B+', 460, 'Pending');

INSERT INTO blood_inventory (donation_id, blood_type, volume_ml, received_date, expiration_date, storage_location) VALUES
(1, 'O+', 450, '2023-10-05', '2023-11-19', 'Fridge A1'),
(2, 'A-', 480, '2023-10-06', '2023-11-20', 'Fridge B2');

INSERT INTO requests (hospital_id, blood_type, quantity_units, urgency, status, request_date, needed_by_date) VALUES
(1, 'O+', 2, 'High', 'Fulfilled', '2023-10-08', '2023-10-10'),
(2, 'A-', 1, 'Medium', 'Approved', '2023-10-09', '2023-10-15');

INSERT INTO activity_log (staff_id, activity_type, description, table_affected, record_id) VALUES
(1, 'ADD', 'Added new donor John Doe', 'donors', 1),
(3, 'UPDATE', 'Updated inventory for donation #1', 'blood_inventory', 1),
(2, 'REQUEST', 'Processed blood request from City General Hospital', 'requests', 1);
