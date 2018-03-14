DROP TABLE IF EXISTS observed_data CASCADE;
DROP TABLE IF EXISTS appuser CASCADE;
DROP TABLE IF EXISTS userPlants CASCADE;

CREATE TABLE observed_data (
	iteration	NUMERIC(1000, 0)	PRIMARY KEY,
	moisture	NUMERIC(1000, 1000)
);

create table appuser (
	id VARCHAR(50) PRIMARY KEY,
	password VARCHAR(50),
	name VARCHAR(50),
	age INT,
	sex VARCHAR(6),
	phone BIGINT,
	location VARCHAR(50)
);

create table userPlants (
	ownerID VARCHAR(50) PRIMARY KEY REFERENCES appuser(id) ON DELETE CASCADE,
	plantName VARCHAR(50),
	minMoisture INT
);
