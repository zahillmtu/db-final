USE zahill;
DELIMITER //
CREATE PROCEDURE create_student (id INT, name VARCHAR(30), password VARCHAR(50), major VARCHAR(20))
begin
    INSERT INTO Student VALUES (id, name, password, major);
end //
