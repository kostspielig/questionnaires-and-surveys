CREATE TABLE administrator (
	admin_id INTEGER PRIMARY KEY, 
	password TEXT
);

CREATE TABLE experiment (
	exp_id INT PRIMARY KEY, 
	name TEXT,
	admin_id INT NOT NULL,
	FOREIGN KEY (admin_id) REFERENCES administrator(admin_id)
		ON DELETE CASCADE
);

CREATE TABLE survey (
	sur_id INT PRIMARY KEY, 
	exp_id INT NOT NULL,
	name TEXT, 
	questions_per_page NUMERIC, 
	table_border_thickness NUMERIC, 
	table_cell_padding NUMERIC, 
	table_cell_spacing TEXT, 
	table_width TEXT,
	FOREIGN KEY(exp_id) REFERENCES experiment(exp_id)
		ON DELETE CASCADE
);

CREATE TABLE question (
	que_id INT PRIMARY KEY,
	sur_id INT NOT NULL,
	exp_id INT NOT NULL,
	item_code TEXT,
	item TEXT,
	response_type TEXT,
	FOREIGN KEY (sur_id) REFERENCES survey(sur_id)	
		ON DELETE CASCADE, 
	FOREIGN KEY (exp_id) REFERENCES experiment(exp_id)
		ON DELETE CASCADE
);

CREATE TABLE participant (
	part_id INT PRIMARY KEY,
	sur_id INT NOT NULL,
	name TEXT,
	FOREIGN KEY (sur_id) REFERENCES survey(sur_id)
		ON DELETE CASCADE
);

CREATE TABLE user_questions (
	user_question_id INT PRIMARY KEY,
	part_id INT NOT NULL,
	question TEXT,
	answer TEXT,
	FOREIGN KEY (part_id) REFERENCES participant(part_id)
		ON DELETE CASCADE
);

CREATE TABLE answer (
	an TEXT PRIMARY KEY,
	part_id INT NOT NULL,
	que_id INT NOT NULL,
	FOREIGN KEY (part_id) REFERENCES participant(part_id)
		ON DELETE CASCADE,
	FOREIGN KEY (que_id) REFERENCES question(que_id)
		ON DELETE CASCADE
	
)