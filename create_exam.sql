USE zahill;
DELIMITER //
CREATE PROCEDURE create_exam (name VARCHAR(20), total_points INT)
begin
    INSERT INTO Exam VALUES (name, CURDATE(), total_points);
end //
