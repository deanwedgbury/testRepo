DROP TABLE observed_data CASCADE;

CREATE TABLE observed_data (
	iteration	NUMERIC(1000, 0)	PRIMARY KEY,
	moisture	NUMERIC(1000, 1000)
);