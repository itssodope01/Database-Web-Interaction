INSERT INTO Participants (ID_Participants, ID_Positions, First_name, Last_name)
VALUES
(1, 1, 'Andrzej', 'Sowa'),
(2, 2, 'Andrzej', 'Wrobel'),
(3, 3, 'Andrzej', 'Kepa'),
(4, 1, 'Janusz', 'Wojcicki'),
(5, 2, 'Anna', 'Niecko');

INSERT INTO Positions (ID_Positions, Position)
VALUES
(1, 'adjunct'),
(2, 'assistant'),
(3, 'specialist');

INSERT INTO Institutions (ID_Institutions, Name, Address1, Address2)
VALUES
(1, 'AGH Krakow', 'Adama Mickiewicza 30', '30-059 Kraków'),
(2, 'Nano Ltd.', 'Mazowiecka St. 6', '30-065 Krakow');

INSERT INTO Lecturers (ID_Lecturers, Title, Initial_Name, Family_Name, ID_Institutions)
VALUES
(1, 'Dr.', 'Jacek', 'Kolarski', 1),
(2, 'Prof.', 'Jan', 'Zarzeczny', 2);

INSERT INTO Courses (ID_Courses, Course_Code, Course_Name, ID_Lecturers, Date, Place)
VALUES
(1, '2018_01', 'psychology for teachers', 1, '2018-02-17', 'Krakow, Mickiewicz Av. 30, B-4, classroom 5'),
(2, '2018_02', 'handling of computer games', 2, '2018-03-27', 'Krakow, Reymonta St. 11, room 10');

INSERT INTO Course_Grading (ID_Courses, ID_Participants, Grade)
VALUES
(1, 1, '3.0'),
(1, 2, '5.0'),
(1, 3, '4.5'),
(2, 2, 'passed'),
(2, 4, 'passed'),
(2, 5, 'passed');
