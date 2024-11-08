CREATE TABLE web_developers (
    web_dev_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR (50),
    first_name VARCHAR (50),
    last_name VARCHAR (50),
    date_of_birth VARCHAR (50),
    specialization TEXT,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE projects (
    project_id INT AUTO_INCREMENT PRIMARY KEY,
    project_name VARCHAR (50),
    technologies_used TEXT,
    web_dev_id INT,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE user_passwords (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50),
  password VARCHAR(50),
  date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  
);
