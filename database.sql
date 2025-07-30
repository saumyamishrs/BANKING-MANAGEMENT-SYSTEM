CREATE DATABASE testing;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Unique identifier for each user
    username VARCHAR(50) NOT NULL,          -- Username with a max length of 50
    email VARCHAR(100) NOT NULL UNIQUE,     -- Email with a max length of 100, must be unique
    phone VARCHAR(15) NOT NULL,          -- Phone number with a max length of 15
    password VARCHAR(255) NOT NULL,         -- Password (hashed), max length 255
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Timestamp for when the record was created
);

CREATE TABLE admin(
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(20) NOT NULL,
    password VARCHAR(250) NOT NULL,
);
INSERT INTO admin (username, password) VALUES
('Shashank', '123'),
('Rudra', '456'),
('Aditi','aditi12'),
('Saumya','saumya12');

CREATE TABLE account (
    account_number INT PRIMARY KEY AUTO_INCREMENT, -- Primary key, auto-increment starting at 1000
    name VARCHAR(100) NOT NULL,                    -- Account holder's name
    father_name VARCHAR(200) NOT NULL,              -- Father's name
    gender ENUM('Male', 'Female', 'Other') NOT NULL, -- Gender with predefined options
    phone VARCHAR(15) NOT NULL,                 -- Phone number
    dob DATE NOT NULL,                             -- Date of birth
    occupation VARCHAR(50),                        -- Occupation
    pancard VARCHAR(10) UNIQUE,                   -- PAN card number (unique identifier)
    aadhar VARCHAR(12) NOT NULL,                    -- adhar card
    address TEXT,                                  -- Address
    marital_status ENUM('Single', 'Married', 'Divorced', 'Widowed'), -- Marital status
    username VARCHAR(50) NOT NULL,                  -- banking username
    password VARCHAR(250) NOT NULL,                     -- banking password
    email VARCHAR(100) NOT NULL,                    -- email
    money DECIMAL(15,2),                  -- Money required (decimal for precision)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Timestamp for when the record was created
) AUTO_INCREMENT=1000; -- Start auto-increment from 1000

CREATE TABLE daybook_table (
    id INT AUTO_INCREMENT PRIMARY KEY,
    account_number INT (20),
    transaction_type ENUM('credit', 'debit') NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    transaction_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (account_number) REFERENCES account(account_number)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);
INSERT INTO account (
    name, father_name, gender, phone, dob, occupation, pancard, 
    aadhar, marital_status, username, password, email, money
) VALUES 
('Aarav Sharma', 'Ramesh Sharma', 'Male', '9123456780', '1990-03-25', 'Engineer', 'ABCPR1234F', '123456789012', 'Unmarried', 'Aarav', 'aarav123@', 'aarav.sharma@gmail.com', 450000),
('Ananya Gupta', 'Vijay Gupta', 'Female', '9876543210', '1988-07-12', 'Doctor', 'BCDQR5678G', '234567890123', 'Married', 'Ananya', 'ananya123@', 'ananya.gupta@gmail.com', 520000),
('Rohan Mehta', 'Sunil Mehta', 'Male', '9898989898', '1992-01-15', 'Teacher', 'CDEQS8912H', '345678901234', 'Unmarried', 'Rohan', 'rohan123@', 'rohan.mehta@gmail.com', 300000),
('Ishika Singh', 'Rajesh Singh', 'Female', '9123456781', '1995-11-20', 'Banker', 'DEFRT4567J', '456789012345', 'Unmarried', 'Ishika', 'ishika123@', 'ishika.singh@gmail.com', 200000),
('Arjun Verma', 'Kamal Verma', 'Male', '9101010101', '1998-06-09', 'Student', 'EFGTR8901K', '567890123456', 'Unmarried', 'Arjun', 'arjun123@', 'arjun.verma@gmail.com', 150000),
('Kavya Agarwal', 'Manoj Agarwal', 'Female', '9123004005', '1990-04-15', 'Business', 'XWZPU1234L', '234560012345', 'Married', 'Kavya', 'kavya123@', 'kavya.agarwal@gmail.com', 550000),
('Aditya Pandey', 'Mahesh Pandey', 'Male', '7894561230', '1986-03-20', 'Engineer', 'LMNOP9876G', '123789456789', 'Married', 'Aditya', 'aditya123@', 'aditya.pandey@gmail.com', 350000),
('Neha Roy', 'Suraj Roy', 'Female', '9873216540', '1993-08-05', 'HR Manager', 'GHZPQ5612J', '456123789123', 'Unmarried', 'Neha', 'neha123@', 'neha.roy@gmail.com', 290000),
('Varun Kapoor', 'Raj Kapoor', 'Male', '9123456321', '1991-12-11', 'Marketing', 'AQWZX9876K', '789456123012', 'Married', 'Varun', 'varun123@', 'varun.kapoor@gmail.com', 430000),
('Priya Desai', 'Kiran Desai', 'Female', '8569871200', '1985-06-20', 'Teacher', 'FRTYU7890H', '456789123789', 'Married', 'Priya', 'priya123@', 'priya.desai@gmail.com', 210000),
('Siddharth Nair', 'Vivek Nair', 'Male', '9898981212', '1989-07-18', 'Software Developer', 'GHIJK5643L', '789654123111', 'Unmarried', 'Siddharth', 'siddharth123@', 'siddharth.nair@gmail.com', 370000),
('Meera Iyer', 'Shankar Iyer', 'Female', '9876543219', '1992-11-02', 'Lawyer', 'JKLMN4567K', '567890123987', 'Married', 'Meera', 'meera123@', 'meera.iyer@gmail.com', 410000),
('Vikram Arora', 'Rajeev Arora', 'Male', '9878906543', '1987-09-29', 'Doctor', 'ZXCAS5678G', '876543219876', 'Married', 'Vikram', 'vikram123@', 'vikram.arora@gmail.com', 530000),
('Riya Chawla', 'Ashok Chawla', 'Female', '8123456782', '1995-01-16', 'Entrepreneur', 'POIUY4321M', '456789101112', 'Unmarried', 'Riya', 'riya123@', 'riya.chawla@gmail.com', 180000),
('Dhruv Patel', 'Ketan Patel', 'Male', '7894569871', '1993-05-05', 'Accountant', 'LKJHG7890F', '123456781234', 'Unmarried', 'Dhruv', 'dhruv123@', 'dhruv.patel@gmail.com', 280000),
('Swati Joshi', 'Narendra Joshi', 'Female', '7589456123', '1991-03-12', 'Bank Manager', 'ERTYU1234D', '567890121314', 'Married', 'Swati', 'swati123@', 'swati.joshi@gmail.com', 460000),
('Karan Malhotra', 'Puneet Malhotra', 'Male', '8471923748', '1990-02-22', 'Civil Engineer', 'POIUW4567H', '890123456789', 'Married', 'Karan', 'karan123@', 'karan.malhotra@gmail.com', 330000),
('Radhika Kapoor', 'Amit Kapoor', 'Female', '8976543214', '1994-10-11', 'Designer', 'XCVBN8901K', '345678901212', 'Unmarried', 'Radhika', 'radhika123@', 'radhika.kapoor@gmail.com', 250000),
('Tushar Saxena', 'Harish Saxena', 'Male', '7899871230', '1992-07-30', 'Data Analyst', 'ASDFG1234J', '789456123789', 'Unmarried', 'Tushar', 'tushar123@', 'tushar.saxena@gmail.com', 320000),
('Simran Kaur', 'Gurmeet Kaur', 'Female', '7568942312', '1988-06-15', 'Professor', 'HJKLU7890F', '345678901234', 'Married', 'Simran', 'simran123@', 'simran.kaur@gmail.com', 240000),
('Nitin Bhatia', 'Dinesh Bhatia', 'Male', '7896543212', '1991-05-10', 'Consultant', 'YTREW5432N', '234567891012', 'Unmarried', 'Nitin', 'nitin123@', 'nitin.bhatia@gmail.com', 420000),
('Sneha Pillai', 'Raghav Pillai', 'Female', '9998877654', '1989-02-14', 'Architect', 'LKOIU7891P', '987654321123', 'Married', 'Sneha', 'sneha123@', 'sneha.pillai@gmail.com', 340000),
('Rajeev Sharma', 'Harish Sharma', 'Male', '8887766554', '1988-12-22', 'Manager', 'QWERU5432T', '345678901456', 'Married', 'Rajeev', 'rajeev123@', 'rajeev.sharma@gmail.com', 480000),
('Ishita Malhotra', 'Kunal Malhotra', 'Female', '9988776655', '1992-10-30', 'Journalist', 'GHJKL7892Q', '567890121314', 'Unmarried', 'Ishita', 'ishita123@', 'ishita.malhotra@gmail.com', 260000),
('Kabir Das', 'Suraj Das', 'Male', '9012345678', '1990-03-17', 'Photographer', 'ZXCVB1234M', '678901212345', 'Unmarried', 'Kabir', 'kabir123@', 'kabir.das@gmail.com', 310000),
('Anjali Sen', 'Narayan Sen', 'Female', '9876501234', '1987-11-19', 'HR Specialist', 'POIUYT5678N', '123789456123', 'Married', 'Anjali', 'anjali123@', 'anjali.sen@gmail.com', 275000),
('Manish Tiwari', 'Keshav Tiwari', 'Male', '9123456789', '1993-07-05', 'Technician', 'ERTYUI7654B', '345678901567', 'Unmarried', 'Manish', 'manish123@', 'manish.tiwari@gmail.com', 230000),
('Pooja Kapoor', 'Shyam Kapoor', 'Female', '9011223344', '1989-01-26', 'Interior Designer', 'ASDFG4321L', '456789101234', 'Married', 'Pooja', 'pooja123@', 'pooja.kapoor@gmail.com', 450000),
('Amit Chauhan', 'Mohan Chauhan', 'Male', '9198765432', '1991-09-14', 'Bank Teller', 'WERTY5678K', '789123456890', 'Unmarried', 'Amit', 'amit123@', 'amit.chauhan@gmail.com', 380000),
('Krishna Ghosh', 'Subhash Ghosh', 'Male', '7890456123', '1995-06-23', 'Researcher', 'LKJHG1234P', '987654321011', 'Unmarried', 'Krishna', 'krishna123@', 'krishna.ghosh@gmail.com', 190000),
('Arpita Roy', 'Nikhil Roy', 'Female', '7887654321', '1992-08-07', 'Social Worker', 'ASDFG9876J', '123456789111', 'Unmarried', 'Arpita', 'arpita123@', 'arpita.roy@gmail.com', 210000),
('Kunal Joshi', 'Harsh Joshi', 'Male', '7778889990', '1989-04-12', 'Electrician', 'ZXCVB4321X', '567890123111', 'Married', 'Kunal', 'kunal123@', 'kunal.joshi@gmail.com', 250000),
('Nidhi Ahuja', 'Vinod Ahuja', 'Female', '7011223344', '1986-02-11', 'NGO Worker', 'QWERT5678B', '678901123789', 'Married', 'Nidhi', 'nidhi123@', 'nidhi.ahuja@gmail.com', 220000),
('Abhinav Mishra', 'Rajan Mishra', 'Male', '8765432109', '1994-11-08', 'System Analyst', 'YTREW8765M', '345678909012', 'Unmarried', 'Abhinav', 'abhinav123@', 'abhinav.mishra@gmail.com', 270000),
('Ritika Nair', 'Prakash Nair', 'Female', '9876543333', '1993-03-04', 'Marketing Manager', 'RTYUI6543P', '123789456112', 'Married', 'Ritika', 'ritika123@', 'ritika.nair@gmail.com', 290000),
('Harsh Vardhan', 'Om Vardhan', 'Male', '8889997776', '1990-08-01', 'Consultant', 'LKIUY1234Z', '678901234578', 'Married', 'Harsh', 'harsh123@', 'harsh.vardhan@gmail.com', 310000),
('Divya Mehta', 'Sanjay Mehta', 'Female', '9123004455', '1992-05-30', 'Dietitian', 'OPIUY7654L', '345678912123', 'Unmarried', 'Divya', 'divya123@', 'divya.mehta@gmail.com', 260000),
('Aryan Khanna', 'Kishore Khanna', 'Male', '9988001234', '1991-02-20', 'Copywriter', 'WERTY4321N', '123789098765', 'Unmarried', 'Aryan', 'aryan123@', 'aryan.khanna@gmail.com', 280000),
('Smita Banerjee', 'Anil Banerjee', 'Female', '9887766551', '1994-01-19', 'Author', 'JKLUI7890X', '456789012345', 'Unmarried', 'Smita', 'smita123@', 'smita.banerjee@gmail.com', 230000),
('Vikas Yadav', 'Mahesh Yadav', 'Male', '8765678987', '1988-10-31', 'Civil Engineer', 'ZXVBC8765M', '234567891234', 'Married', 'Vikas', 'vikas123@', 'vikas.yadav@gmail.com', 400000),
('Anil Singh', 'Rajesh Singh', 'Male', '9898908765', '1986-07-12', 'Project Manager', 'WQERY7654J', '345678901121', 'Married', 'Anil', 'anil123@', 'anil.singh@gmail.com', 470000),
('Meenal Saxena', 'Deepak Saxena', 'Female', '9900778899', '1993-06-27', 'Professor', 'QWERT9876L', '678901234567', 'Married', 'Meenal', 'meenal123@', 'meenal.saxena@gmail.com', 300000),
('Rajat Arora', 'Naresh Arora', 'Male', '8112233445', '1991-11-19', 'Engineer', 'ZCVBN1234M', '345678909876', 'Unmarried', 'Rajat', 'rajat123@', 'rajat.arora@gmail.com', 320000),
('Tina Paul', 'Sunny Paul', 'Female', '8900987654', '1995-08-09', 'Content Writer', 'PLKIJ8765Z', '678901234123', 'Unmarried', 'Tina', 'tina123@', 'tina.paul@gmail.com', 220000);

CREATE TABLE user_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    account_number INT NOT NULL,
    request_type ENUM('amount', 'credentials') NOT NULL,
    requested_amount DECIMAL(10, 2) DEFAULT NULL,
    new_username VARCHAR(255) DEFAULT NULL,
    new_password VARCHAR(255) DEFAULT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    request_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (account_number) REFERENCES account(account_number)
);
ALTER TABLE user_requests 
DROP FOREIGN KEY user_requests_ibfk_1;

ALTER TABLE user_requests 
ADD CONSTRAINT user_requests_ibfk_1 
FOREIGN KEY (account_number) REFERENCES account(account_number) 
ON DELETE CASCADE;

