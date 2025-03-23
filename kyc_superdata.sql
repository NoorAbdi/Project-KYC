-- SQL Script to define and populate KYC system for banks
-- Create database
CREATE DATABASE IF NOT EXISTS kyc_superdata;

-- Use the database
USE kyc_superdata;

-- DROP TABLES (if exist to start fresh)
DROP TABLE IF EXISTS applications, kyc_cust_account_opening, kyc_cust_employment,
                    kyc_cust_details, kyc_compliance, kyc_customers, banks, kyc_users;

CREATE TABLE kyc_users (
    uid INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(250) NOT NULL UNIQUE,
    password VARCHAR(250) NOT NULL,
    user_type ENUM(
        'compliance',
        'customer'
    )
) ENGINE=InnoDB;

CREATE TABLE kyc_customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(200) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE banks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL, -- Links to user_account
    bank_id INT NOT NULL, -- Links to banks
    status ENUM('To Review', 'Approved', 'Rejected') DEFAULT 'To Review', -- Application status
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES kyc_customers(id) ON DELETE CASCADE,
    FOREIGN KEY (bank_id) REFERENCES banks(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE kyc_compliance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Email VARCHAR(200) NOT NULL UNIQUE,
    FirstName VARCHAR(200) NOT NULL,
    LastName VARCHAR(200) NOT NULL,
    password VARCHAR(200) NOT NULL, -- Use hashed passwords for security
    Placement INT NOT NULL,
    DateOfEntry TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (Placement) REFERENCES banks(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table for Customer Details
CREATE TABLE kyc_cust_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    ktp_number VARCHAR(50) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    mother_maiden_name VARCHAR(100) NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL,
    religion VARCHAR(50) NOT NULL,
    education VARCHAR(50) NOT NULL,
    date_of_birth DATE NOT NULL,
    place_of_birth VARCHAR(100) NOT NULL,
    phone_number VARCHAR(15) NOT NULL,
    marital_status VARCHAR(50) NOT NULL,
    province VARCHAR(100) NOT NULL,
    regency_city VARCHAR(100) NOT NULL,
    district VARCHAR(100) NOT NULL,
    post_code VARCHAR(10) NOT NULL,
    address TEXT NOT NULL,
    residence_status VARCHAR(50) NOT NULL,
    mailing_address VARCHAR(100) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES kyc_customers(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table for Employment Details
CREATE TABLE kyc_cust_employment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    current_job VARCHAR(100) NOT NULL,
    job_status VARCHAR(50),
    company_name VARCHAR(100),
    business_sector VARCHAR(100),
    start_working_date DATE,
    position VARCHAR(100),
    FOREIGN KEY (user_id) REFERENCES kyc_customers(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE kyc_cust_account_opening (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL, -- Links to user_account
    account_type ENUM(
        'Tabungan', 
        'Tabungan Bisnis', 
        'Bisnis', 
        'Tabungan Valas', 
        'Tabungan Mitra Usaha', 
        'Tabungan Karyawan/Pelajar'
    ),
    purpose ENUM('Saving', 'Investment', 'Loan/Credit', 'Business Transaction'),
    FOREIGN KEY (user_id) REFERENCES kyc_customers(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Insert data into kyc_users
INSERT INTO kyc_users (email, password, user_type)
VALUES
    ('john.doe@bankmandiri.co.id', 'hashedpassword1', 'compliance'),
    ('jane.smith@bca.co.id', 'hashedpassword2', 'compliance'),
    ('rahmat.santoso@bri.co.id', 'hashedpassword3', 'compliance'),
    ('lisa.halim@cimbniaga.co.id', 'hashedpassword4', 'compliance'),
    ('agus.pratama@bni.co.id', 'hashedpassword5', 'compliance'),
    ('andi.susanto@gmail.com', 'hashedpassword6', 'customer'),
    ('maria.clara@yahoo.com', 'hashedpassword7', 'customer'),
    ('agus.wibowo@hotmail.com', 'hashedpassword8', 'customer'),
    ('siti.khadijah@outlook.com', 'hashedpassword9', 'customer'),
    ('budi.setiawan@gmail.com', 'hashedpassword10', 'customer'),
    ('nina.febriani@yahoo.com', 'hashedpassword11', 'customer'),
    ('arif.hidayat@hotmail.com', 'hashedpassword12', 'customer'),
    ('dian.kusuma@gmail.com', 'hashedpassword13', 'customer'),
    ('fahmi.nurhalim@yahoo.com', 'hashedpassword14', 'customer'),
    ('lina.rahmawati@hotmail.com', 'hashedpassword15', 'customer'),
    ('reza.pratama@outlook.com', 'hashedpassword16', 'customer'),
    ('yuni.safitri@gmail.com', 'hashedpassword17', 'customer'),
    ('eko.santoso@yahoo.com', 'hashedpassword18', 'customer'),
    ('susi.wardhani@gmail.com', 'hashedpassword19', 'customer'),
    ('fadhil.ramadhan@hotmail.com', 'hashedpassword20', 'customer');

-- Insert data into banks
INSERT INTO banks (name)
VALUES
    ('BANK MANDIRI'),
    ('BCA'),
    ('BRI'),
    ('CIMB NIAGA'),
    ('BNI');

-- Insert data into kyc_customers
INSERT INTO kyc_customers (email)
VALUES
    ('andi.susanto@gmail.com'),
    ('maria.clara@yahoo.com'),
    ('agus.wibowo@hotmail.com'),
    ('siti.khadijah@outlook.com'),
    ('budi.setiawan@gmail.com'),
    ('nina.febriani@yahoo.com'),
    ('arif.hidayat@hotmail.com'),
    ('dian.kusuma@gmail.com'),
    ('fahmi.nurhalim@yahoo.com'),
    ('lina.rahmawati@hotmail.com'),
    ('reza.pratama@outlook.com'),
    ('yuni.safitri@gmail.com'),
    ('eko.santoso@yahoo.com'),
    ('susi.wardhani@gmail.com'),
    ('fadhil.ramadhan@hotmail.com');

-- Insert data into kyc_cust_details
INSERT INTO kyc_cust_details (user_id, ktp_number, first_name, last_name, mother_maiden_name, gender, religion, education, date_of_birth, place_of_birth, phone_number, marital_status, province, regency_city, district, post_code, address, residence_status, mailing_address)
VALUES
    (1, '1234567890123451', 'ANDI', 'SUSANTO', 'KARTINI', 'Male', 'Islam', 'SMA', '1990-03-15', 'SURABAYA', '081234567890', 'Menikah', 'JAWA TIMUR', 'SURABAYA', 'GUBENG', '60281', 'JL. DARMO NO. 2', 'Milik Sendiri', 'Alamat Sesuai ID'),
    (2, '1234567890123452', 'MARIA', 'CLARA', 'SOFIA', 'Female', 'Katolik', 'S1', '1985-05-20', 'MEDAN', '081234567891', 'Menikah', 'SUMATERA UTARA', 'MEDAN', 'MEDAN BARU', '20111', 'JL. GATOT SUBROTO NO. 5', 'Sewa/Kontrakan', 'Alamat Tinggal'),
    (3, '1234567890123453', 'AGUS', 'WIBOWO', 'SARI', 'Male', 'Islam', 'S1', '1992-07-10', 'BANDUNG', '081234567892', 'Lajang', 'JAWA BARAT', 'BANDUNG', 'CICADAS', '40123', 'JL. AHMAD YANI NO. 3', 'Milik Keluarga', 'Alamat Sesuai ID'),
    (4, '1234567890123454', 'SITI', 'KHADIJAH', 'NURHAYATI', 'Female', 'Islam', 'Diploma', '1997-01-15', 'JAKARTA', '081234567893', 'Lajang', 'DKI JAKARTA', 'JAKARTA SELATAN', 'PANCORAN', '12780', 'JL. MT HARYONO NO. 6', 'Dinas/Instansi', 'Alamat Tinggal'),
    (5, '1234567890123455', 'BUDI', 'SETIAWAN', 'KARTINI', 'Male', 'Islam', 'SMA', '1988-11-22', 'SEMARANG', '081234567894', 'Menikah', 'JAWA TENGAH', 'SEMARANG', 'SEMARANG BARAT', '50144', 'JL. PEMUDA NO. 9', 'Milik Sendiri', 'Alamat Sesuai ID'),
    (6, '1234567890123456', 'NINA', 'FEBRIANI', 'ANITA', 'Female', 'Protestan', 'S2', '1995-09-30', 'PALEMBANG', '081234567895', 'Menikah', 'SUMATERA SELATAN', 'PALEMBANG', 'SEBERANG ULU I', '30113', 'JL. AMPERA RAYA NO. 10', 'Milik Sendiri', 'Alamat Sesuai ID'),
    (7, '1234567890123457', 'ARIF', 'HIDAYAT', 'SULASTRI', 'Male', 'Islam', 'SMA', '1986-08-19', 'MAKASSAR', '081234567896', 'Menikah', 'SULAWESI SELATAN', 'MAKASSAR', 'TAMALANREA', '90245', 'JL. PERINTIS KEMERDEKAAN NO. 12', 'Milik Keluarga', 'Alamat Tinggal'),
    (8, '1234567890123458', 'DIAN', 'KUSUMA', 'AISYAH', 'Female', 'Hindu', 'Diploma', '1998-04-25', 'DENPASAR', '081234567897', 'Lajang', 'BALI', 'DENPASAR', 'DENPASAR BARAT', '80221', 'JL. TEUKU UMAR NO. 8', 'Sewa/Kontrakan', 'Alamat Tinggal'),
    (9, '1234567890123459', 'FAHMI', 'NURHALIM', 'SITI', 'Male', 'Islam', 'S1', '1990-12-12', 'YOGYAKARTA', '081234567898', 'Menikah', 'DI YOGYAKARTA', 'YOGYAKARTA', 'UMBULHARJO', '55161', 'JL. MALIOBORO NO. 15', 'Milik Sendiri', 'Alamat Sesuai ID'),
    (10, '1234567890123460', 'LINA', 'RAHMAWATI', 'KARTIKA', 'Female', 'Buddha', 'S1', '1993-03-05', 'PONTIANAK', '081234567899', 'Lajang', 'KALIMANTAN BARAT', 'PONTIANAK', 'PONTIANAK SELATAN', '78121', 'JL. DIPONEGORO NO. 18', 'Milik Sendiri', 'Alamat Sesuai ID'),
    (11, '1234567890123461', 'REZA', 'PRATAMA', 'KARTINI', 'Male', 'Islam', 'SMA', '1991-07-17', 'PADANG', '081234567800', 'Menikah', 'SUMATERA BARAT', 'PADANG', 'PADANG SELATAN', '25136', 'JL. ADINEGORO NO. 22', 'Milik Keluarga', 'Alamat Tinggal'),
    (12, '1234567890123462', 'YUNI', 'SAFITRI', 'ANITA', 'Female', 'Protestan', 'S1', '1989-06-10', 'MANADO', '081234567801', 'Menikah', 'SULAWESI UTARA', 'MANADO', 'TIKALA', '95119', 'JL. SAM RATULANGI NO. 25', 'Sewa/Kontrakan', 'Alamat Tinggal'),
    (13, '1234567890123463', 'EKO', 'SANTOSO', 'SULASTRI', 'Male', 'Islam', 'Diploma', '1994-02-02', 'PEKANBARU', '081234567802', 'Lajang', 'RIAU', 'PEKANBARU', 'SUKAJADI', '28126', 'JL. TUANKU TAMBUSAI NO. 28', 'Milik Sendiri', 'Alamat Sesuai ID'),
    (14, '1234567890123464', 'SUSI', 'WARDHANI', 'AISYAH', 'Female', 'Katolik', 'S1', '1996-09-22', 'PALANGKA RAYA', '081234567803', 'Menikah', 'KALIMANTAN TENGAH', 'PALANGKA RAYA', 'JEKAN RAYA', '73112', 'JL. AHMAD YANI NO. 33', 'Milik Keluarga', 'Alamat Tinggal'),
    (15, '1234567890123465', 'FADHIL', 'RAMADHAN', 'NURHAYATI', 'Male', 'Islam', 'S1', '1992-11-11', 'BALIKPAPAN', '081234567804', 'Menikah', 'KALIMANTAN TIMUR', 'BALIKPAPAN', 'BALIKPAPAN SELATAN', '76113', 'JL. SUDIRMAN NO. 40', 'Milik Sendiri', 'Alamat Sesuai ID');

-- Insert data into kyc_cust_employment
INSERT INTO kyc_cust_employment (user_id, current_job, job_status, company_name, business_sector, start_working_date, position)
VALUES
    (1, 'Wiraswasta', 'Tetap', 'PT MAJU BERSAMA', 'Teknologi', '2015-06-01', 'Manager'),
    (2, 'Swasta', 'Kontrak', 'PT INOVASI GLOBAL', 'Keuangan', '2020-09-15', 'Analyst'),
    (3, 'PNS/TNI/POLRI', 'Tetap', 'PEMERINTAH KOTA BANDUNG', 'Pemerintahan', '2010-01-01', 'Staf Ahli'),
    (4, 'Pelajar/Mahasiswa', NULL, NULL, NULL, NULL, NULL),
    (5, 'Ibu Rumah Tangga', NULL, NULL, NULL, NULL, NULL),
    (6, 'Swasta', 'Tetap', 'PT SAHABAT SEJAHTERA', 'Retail', '2018-03-12', 'Supervisor'),
    (7, 'Penyelenggaran Negara', 'Honorer', 'PEMERINTAH DAERAH MAKASSAR', 'Pemerintahan', '2019-05-18', 'Asisten'),
    (8, 'Swasta', 'Kontrak', 'PT INDAH PERMATA', 'Transportasi', '2021-11-01', 'Driver'),
    (9, 'Wiraswasta', 'Tetap', 'TOKO NUSA INDAH', 'Retail', '2016-07-20', 'Owner'),
    (10, 'Swasta', 'Tetap', 'PT KARYA ABADI', 'Teknologi', '2017-02-10', 'IT Support'),
    (11, 'Swasta', 'Tetap', 'PT MULTIMEDIA ASIA', 'Media', '2022-04-01', 'Content Creator'),
    (12, 'Swasta', 'Tetap', 'PT CIPTA SEJAHTERA', 'Keuangan', '2019-08-23', 'Accountant'),
    (13, 'Pelajar/Mahasiswa', NULL, NULL, NULL, NULL, NULL),
    (14, 'Penyelenggaran Negara', 'Tetap', 'PEMERINTAH KOTA JAKARTA', 'Pemerintahan', '2009-03-01', 'Kepala Seksi'),
    (15, 'Swasta', 'Tetap', 'PT MITRA TEKNOLOGI', 'Teknologi', '2014-06-05', 'Engineer');

-- Insert data into account_opening
INSERT INTO kyc_cust_account_opening (user_id, account_type, purpose)
VALUES
    (1, 'Tabungan', 'Saving'),
    (2, 'Tabungan Valas', 'Investment'),
    (3, 'Tabungan Mitra Usaha', 'Business Transaction'),
    (4, 'Tabungan Bisnis', 'Loan/Credit'),
    (5, 'Bisnis', 'Saving'),
    (6, 'Tabungan', 'Saving'),
    (7, 'Tabungan Valas', 'Investment'),
    (8, 'Tabungan Mitra Usaha', 'Business Transaction'),
    (9, 'Tabungan Bisnis', 'Loan/Credit'),
    (10, 'Bisnis', 'Saving'),
    (11, 'Tabungan', 'Saving'),
    (12, 'Tabungan Valas', 'Investment'),
    (13, 'Tabungan Mitra Usaha', 'Business Transaction'),
    (14, 'Tabungan Bisnis', 'Loan/Credit'),
    (15, 'Bisnis', 'Saving');
-- Insert data into kyc_compliance
INSERT INTO kyc_compliance (Email, Firstname, Lastname, password, Placement)
VALUES
    ('john.doe@bankmandiri.co.id', 'John', 'Doe', 'hashedpassword1', 1), -- Mandiri
    ('jane.smith@bca.co.id', 'Jane', 'Smith', 'hashedpassword2', 2),     -- BCA
    ('rahmat.santoso@bri.co.id', 'Rahmat', 'Santoso', 'hashedpassword3', 3), -- BRI
    ('lisa.halim@cimbniaga.co.id', 'Lisa', 'Halim', 'hashedpassword4', 4), -- CIMB Niaga
    ('agus.pratama@bni.co.id', 'Agus', 'Pratama', 'hashedpassword5', 5); -- BNI
-- Insert data into applications
-- Insert data into applications
INSERT INTO applications (user_id, bank_id, status, submitted_at)
VALUES
    (1, 1, 'To Review', NOW()),
    (2, 2, 'Approved', NOW()),
    (3, 3, 'Rejected', NOW()),
    (4, 4, 'To Review', NOW()),
    (5, 5, 'Approved', NOW()),
    (6, 1, 'To Review', NOW()),
    (7, 2, 'Rejected', NOW()),
    (8, 3, 'To Review', NOW()),
    (9, 4, 'Approved', NOW()),
    (10, 5, 'To Review', NOW()),
    (11, 1, 'Rejected', NOW()),
    (12, 2, 'Approved', NOW()),
    (13, 3, 'To Review', NOW()),
    (14, 4, 'Approved', NOW()),
    (15, 5, 'Rejected', NOW());