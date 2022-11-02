DROP DATABASE IF EXISTS medical_clinic_2;
CREATE DATABASE medical_clinic_2;
USE medical_clinic_2;

CREATE TABLE IF NOT EXISTS User_Account (
	user_ID INT NOT NULL AUTO_INCREMENT,
    username varchar(35) NOT NULL,
    user_pass varchar(100) NOT NULL,
    user_role varchar(10) NOT NULL
		DEFAULT 'patient',
	user_phone_num varchar(20) NOT NULL,
    user_email_address varchar(45) NOT NULL,
	created_at datetime NOT NULL
		DEFAULT CURRENT_TIMESTAMP,
    updated_at datetime NOT NULL
		DEFAULT CURRENT_TIMESTAMP,
	deleted_flag BOOLEAN NOT NULL
		DEFAULT false,
	PRIMARY KEY (user_ID),
	CHECK (user_role IN ('patient', 'doctor', 'nurse', 'receptionist', 'admin'))
);

CREATE TABLE IF NOT EXISTS Address (
	address_ID INT NOT NULL AUTO_INCREMENT,
	street_address varchar(45) NOT NULL,
    apt_num varchar(20),
    city varchar(20) NOT NULL,
    state varchar(20) NOT NULL,
    zip_code varchar(20) NOT NULL,
    office_add boolean NOT NULL
		DEFAULT false,
    deleted_flag BOOLEAN NOT NULL
		DEFAULT false,
    PRIMARY KEY (address_ID)
);

CREATE TABLE IF NOT EXISTS Department (
	department_number int NOT NULL AUTO_INCREMENT,
    dep_name varchar(45) NOT NULL,
	deleted_flag BOOLEAN NOT NULL
		DEFAULT FALSE,
    PRIMARY KEY (department_number),
    UNIQUE (dep_name)
);

CREATE TABLE IF NOT EXISTS Doctor (
	doc_ID INT NOT NULL AUTO_INCREMENT,
    ssn int NOT NULL,
    dep_num int,
    f_name varchar(45) NOT NULL,
    m_name varchar(45),
    l_name varchar(45) NOT NULL,
    address_ID INT NOT NULL,
    specialty varchar(30) NOT NULL,
    credentials varchar(45),
    sex char NOT NULL,
    doc_user INT NOT NULL,
    primary_doctor BOOLEAN NOT NULL
		DEFAULT FALSE,
	deleted_flag BOOLEAN NOT NULL
		DEFAULT false,
    PRIMARY KEY (doc_ID),
    UNIQUE (ssn, doc_user),
    FOREIGN KEY (dep_num)
		REFERENCES Department (department_number)
        ON DELETE RESTRICT,
	FOREIGN KEY (doc_user)
		REFERENCES User_Account (user_ID)
        ON DELETE RESTRICT,
	FOREIGN KEY (address_ID)
		REFERENCES Address (address_ID)
        ON DELETE RESTRICT,
	CHECK (sex IN ('M', 'F'))
);

CREATE TABLE IF NOT EXISTS Nurse (
	nurse_ID INT NOT NULL AUTO_INCREMENT,
    ssn int NOT NULL,
    dep_num int,
    f_name varchar(20) NOT NULL,
    m_name varchar(20),
    l_name varchar(20) NOT NULL,
    sex char NOT NULL,
    nurse_user INT NOT NULL,
    registered BOOLEAN NOT NULL
		DEFAULT false,
    address_ID INT NOT NULL,
	deleted_flag BOOLEAN NOT NULL
		DEFAULT false,
    PRIMARY KEY (nurse_ID),
    UNIQUE (ssn, nurse_user),
    FOREIGN KEY (dep_num)
		REFERENCES Department (department_number)
        ON DELETE RESTRICT,
	FOREIGN KEY (nurse_user)
		REFERENCES User_Account (user_ID)
        ON DELETE RESTRICT,
	FOREIGN KEY (address_ID)
		REFERENCES Address (address_ID)
        ON DELETE RESTRICT,
	CHECK (sex IN ('M', 'F'))
);

CREATE TABLE IF NOT EXISTS Receptionist (
	rec_ID INT NOT NULL AUTO_INCREMENT,
    ssn int NOT NULL,
    f_name varchar(20) NOT NULL,
    m_name varchar(20),
    l_name varchar(20) NOT NULL,
    sex char NOT NULL,
    rec_user INT NOT NULL,
    address_ID INT NOT NULL,
	deleted_flag BOOLEAN NOT NULL
		DEFAULT false,
    PRIMARY KEY (rec_ID),
    UNIQUE (ssn, rec_user),
	FOREIGN KEY (rec_user)
		REFERENCES User_Account (user_ID)
        ON DELETE RESTRICT,
	FOREIGN KEY (address_ID)
		REFERENCES Address (address_ID)
        ON DELETE RESTRICT,
    CHECK (sex IN ('M', 'F'))
);

CREATE TABLE IF NOT EXISTS Office (
	office_ID INT NOT NULL AUTO_INCREMENT,
    dep_number int,
    address_ID INT NOT NULL,
    phone_number varchar(20) NOT NULL,
	deleted_flag BOOLEAN NOT NULL
		DEFAULT false,
    PRIMARY KEY (office_ID),
    FOREIGN KEY (dep_number)
		REFERENCES Department (department_number)
		ON DELETE RESTRICT,
	FOREIGN KEY (address_ID)
		REFERENCES Address (address_ID)
		ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS Doctor_Works_In_Office (
	office_ID INT NOT NULL,
    doctor_ID INT NOT NULL,
	deleted_flag BOOLEAN NOT NULL
		DEFAULT false,
    PRIMARY KEY (office_ID, doctor_ID),
    FOREIGN KEY (office_ID)
		REFERENCES Office (office_ID)
		ON DELETE RESTRICT,
    FOREIGN KEY (doctor_ID)
		REFERENCES Doctor (doc_ID)
		ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS Nurse_Works_In_Office (
	office_ID INT NOT NULL,
    nurse_ID INT NOT NULL,
	deleted_flag BOOLEAN NOT NULL
		DEFAULT false,
    PRIMARY KEY (office_ID, nurse_ID),
    FOREIGN KEY (office_ID)
		REFERENCES Office (office_ID)
		ON DELETE RESTRICT,
    FOREIGN KEY (nurse_ID)
		REFERENCES Nurse (nurse_ID)
		ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS Nurse_Works_With_Doctor (
	nurse_ID INT NOT NULL,
    doc_ID INT NOT NULL,
	deleted_flag BOOLEAN NOT NULL
		DEFAULT false,
    PRIMARY KEY (nurse_ID, doc_ID),
    FOREIGN KEY (nurse_ID)
		REFERENCES Nurse (Nurse_ID)
        ON DELETE RESTRICT,
	FOREIGN KEY (doc_ID)
		REFERENCES Doctor (doc_ID)
        ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS Medicine (
	med_ID INT NOT NULL AUTO_INCREMENT,
    brand varchar(20) NOT NULL,
    name varchar(30) NOT NULL,
    description text NOT NULL,
    deleted_flag char NOT NULL DEFAULT 'F',
    PRIMARY KEY (med_ID)
);

CREATE TABLE IF NOT EXISTS Doctor_Prescribes_Medicine (
	doc_ID INT NOT NULL,
    med_ID INT NOT NULL,
	deleted_flag BOOLEAN NOT NULL
		DEFAULT false,
    PRIMARY KEY (doc_ID, med_ID),
    FOREIGN KEY (doc_ID)
		REFERENCES Doctor (doc_ID)
        ON DELETE RESTRICT,
	FOREIGN KEY (med_ID)
		REFERENCES Medicine (med_ID)
        ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS Patient (
	patient_ID INT NOT NULL AUTO_INCREMENT,
    ssn int NOT NULL,
    f_name varchar(20) NOT NULL,
    m_name varchar(20),
    l_name varchar(20) NOT NULL,
    sex char NOT NULL,
    cellphone_number INT,
    homephone_number INT NOT NULL,
    pat_user INT NOT NULL,
    b_date date NOT NULL,
    ethnicity varchar(20) NOT NULL,
    race varchar(20) NOT NULL,
    address_ID INT NOT NULL,
	deleted_flag BOOLEAN NOT NULL
		DEFAULT false,
    PRIMARY KEY (patient_ID),
    UNIQUE (ssn, pat_user),
	FOREIGN KEY (pat_user)
		REFERENCES User_Account (user_ID)
        ON DELETE RESTRICT,
	FOREIGN KEY (address_ID)
		REFERENCES Address (address_ID)
        ON DELETE RESTRICT,
    CHECK (sex IN ('M', 'F'))
);

CREATE TABLE IF NOT EXISTS Medical_Record (
	pat_ID INT NOT NULL,
    allergies text,
    diagnoses text,
    immunizations text,
    progress text,
    treatment_plan text,
	inch_height int NOT NULL,
    pound_weight int NOT NULL,
	deleted_flag BOOLEAN NOT NULL
		DEFAULT false,
    PRIMARY KEY (pat_ID),
    FOREIGN KEY (pat_ID) 
		REFERENCES Patient (patient_ID)
        ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS Doctor_Maintains_Medical_Record (
	pat_ID INT NOT NULL,
    doc_ID INT NOT NULL,
	deleted_flag BOOLEAN NOT NULL
		DEFAULT false,
    PRIMARY KEY (doc_ID, pat_ID),
    FOREIGN KEY (pat_ID)
		REFERENCES Medical_Record (pat_ID)
        ON DELETE RESTRICT,
	FOREIGN KEY (doc_ID)
		REFERENCES Doctor (doc_ID)
        ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS Medical_Record_Contains_Medicine (
	pat_ID INT NOT NULL,
    med_ID INT NOT NULL,
	deleted_flag BOOLEAN NOT NULL
		DEFAULT false,
    PRIMARY KEY (pat_ID, med_ID),
    FOREIGN KEY (pat_ID)
		REFERENCES Medical_Record (pat_ID)
        ON DELETE RESTRICT,
	FOREIGN KEY (med_ID)
		REFERENCES Medicine (med_ID)
        ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS Payment (
	transaction_ID INT NOT NULL,
    patient_ID INT NOT NULL,
    insurance_ID int,
    payment_type varchar(20),
    payment_date timestamp NOT NULL
		DEFAULT current_timestamp,
    amount numeric(4,2),
	deleted_flag BOOLEAN NOT NULL
		DEFAULT false,
    PRIMARY KEY (transaction_ID),
    FOREIGN KEY (patient_ID)
		REFERENCES Patient (patient_ID)
        ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS Appointment (
	app_ID INT NOT NULL AUTO_INCREMENT,
    date_time datetime NOT NULL,
    reason varchar(100),
    office_ID INT,
    doctor_ID INT,
    patient_ID INT,
    payment_ID INT,
    receptionist_ID INT,
    status_flag INT NOT NULL
		DEFAULT 0,
    PRIMARY KEY (app_ID, date_time),
	FOREIGN KEY (office_ID)
		REFERENCES Office (office_ID)
        ON DELETE RESTRICT,
	FOREIGN KEY (doctor_ID)
		REFERENCES Doctor (doc_ID)
        ON DELETE RESTRICT,
	FOREIGN KEY (patient_ID)
		REFERENCES Patient (patient_ID)
        ON DELETE RESTRICT,
	FOREIGN KEY (payment_ID)
		REFERENCES Payment (transaction_ID)
        ON DELETE RESTRICT,
	FOREIGN KEY (receptionist_ID)
		REFERENCES Receptionist (rec_ID)
        ON DELETE RESTRICT,
	CHECK (status_flag IN (0, 1, 2, 3, 4))
);

CREATE TABLE IF NOT EXISTS Nurse_Works_On_Appointment (
	nurse_ID INT NOT NULL,
    appointment_ID INT NOT NULL,
	deleted_flag BOOLEAN NOT NULL
		DEFAULT false,
    PRIMARY KEY (nurse_ID, appointment_ID),
    FOREIGN KEY (nurse_ID)
		REFERENCES Nurse (nurse_ID)
        ON DELETE RESTRICT,
	FOREIGN KEY (appointment_ID)
		REFERENCES Appointment (app_ID)
        ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS Emergency_Contact (
	patient_ID INT NOT NULL AUTO_INCREMENT,
    f_name varchar(20) NOT NULL,
    m_name varchar(20),
    l_name varchar(20) NOT NULL,
    relationship varchar(20),
    b_date date NOT NULL,
    phone_num varchar(20) NOT NULL,
    sex char NOT NULL,
	deleted_flag BOOLEAN NOT NULL
		DEFAULT false,
    PRIMARY KEY (patient_ID),
    FOREIGN KEY (patient_ID)
		REFERENCES Patient (patient_ID)
        ON DELETE RESTRICT,
	CHECK (sex IN ('M', 'F'))
);

CREATE TRIGGER 
	AFTER UPDATE ON Payment 
	FOR EACH ROW 
BEGIN 
	
END;

CREATE