
INSERT INTO Departments 
(dept_num, dept_name, phone_num, office_location, chair_ssn) 
VALUES
(10,'Computer Science', '217-555-2010', 301, NULL),
(20, 'Mathematics', '217-555-2020', 210, NULL);




INSERT INTO Professor 
(ssn, first_name, last_name, sex, street, city, prof_state, zip_code, phone_num, title, salary, dept_num) 
VALUES
('111-22-3345', 'John', 'Carter', 'M', '12 Oak St', 'Springfield', 'IL', '62701', '2175551001', 'Professor', 95000.00, 10),
('222-33-4476', 'Susan', 'Lee', 'F', '45 Maple Ave', 'Springfield', 'IL', '62702', '2175551002', 'Associate Professor', 87000.00, 20),
('333-44-5503', 'Robert', 'Nguyen', 'M', '78 Pine Rd', 'Springfield', 'IL', '62703', '2175551003', 'Assistant Professor', 76000.00, 20);

UPDATE Departments
SET chair_ssn = '111-22-33'
WHERE dept_num = 10;

UPDATE Departments
SET chair_ssn = '222-33-44'
WHERE dept_num = 20;



INSERT INTO Professor_degrees 
(ssn, degree) 
VALUES
('111-22-3345', 'PhD Computer Science'),
('222-33-4476', 'PhD Mathematics');



INSERT INTO Student_record 
(cwid, first_name, last_name, street, city, student_state, zip_code, phone_num, major_dept_num) 
VALUES
(1001, 'Emma', 'Johnson', '101 Birch St', 'Springfield', 'IL', '62704', '2175553001', 10),
(1002, 'Liam', 'Smith', '102 Birch St', 'Springfield', 'IL', '62704', '2175553002', 10),
(1003, 'Olivia', 'Brown', '103 Birch St', 'Springfield', 'IL', '62704', '2175553003', 20),
(1004, 'Noah', 'Davis', '104 Birch St', 'Springfield', 'IL', '62704', '2175553004', 10),
(1005, 'Ava', 'Miller', '105 Birch St', 'Springfield', 'IL', '62704', '2175553005', 20),
(1006, 'William', 'Wilson', '106 Birch St', 'Springfield', 'IL', '62704', '2175553006', 10),
(1007, 'Sophia', 'Moore', '107 Birch St', 'Springfield', 'IL', '62704', '2175553007', 20),
(1008, 'James', 'Taylor', '108 Birch St', 'Springfield', 'IL', '62704', '2175553008', 10);



INSERT INTO Student_minors 
(dept_num, cwid) 
VALUES
(20, 1001),
(20, 1002),
(20, 1004),
(20, 1006),
(10, 1007);



INSERT INTO Course 
(course_num, title, textbook, units, dept_num)
VALUES
(101, 'Introduction to Programming', 'Python Basics', 3, 10),
(201, 'Data Structures', 'Data Structures in C++', 4, 10),
(301, 'Database Systems', 'Database Design Concepts', 3, 10),
(501, 'Calculus I', 'Calculus Early Transcendentals', 4, 20);



INSERT INTO Course_prereq 
(course_num, prereq_course_num) 
VALUES
(201, 101),
(301, 201);



INSERT INTO Sections 
(section_num, course_num, ssn, start_time, end_time, classroom, meet_days, seat_num) 
VALUES
(1, 101, '111-22-3345', '09:00:00', '09:50:00', 101, 'MWF', 30),
(1, 201, '111-22-3345', '10:00:00', '10:50:00', 201, 'MWF', 25),
(1, 301, '333-44-5503', '13:00:00', '14:15:00', 305, 'TR', 20),
(1, 501, '222-33-4476', '08:00:00', '08:50:00', 110, 'MWF', 35),
(2, 101, '333-44-5503', '11:00:00', '12:15:00', 102, 'TR', 30),
(2, 501, '222-33-4476', '09:30:00', '10:45:00', 111, 'TR', 35);



INSERT INTO Enrollment_records 
(cwid, course_num, section_num, grade) 
VALUES
(1001, 101, 1, 'A'),
(1001, 501, 1, 'B+'),
(1002, 101, 2, 'A-'),
(1002, 501, 2, 'B'),
(1003, 501, 1, 'A'),
(1003, 101, 1, 'B+'),
(1004, 101, 2, 'B'),
(1004, 201, 1, 'A-'),
(1005, 501, 2, 'A-'),
(1005, 101, 1, 'B'),
(1006, 101, 1, 'C+'),
(1006, 201, 1, 'B+'),
(1006, 501, 1, 'B'),
(1007, 501, 2, 'A'),
(1007, 101, 2, 'A-'),
(1008, 101, 1, 'B+'),
(1008, 201, 1, 'B'),
(1008, 301, 1, 'A-'),
(1004, 301, 1, 'B+'),
(1002, 201, 1, 'A');













