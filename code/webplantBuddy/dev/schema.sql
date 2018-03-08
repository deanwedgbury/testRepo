drop table appuser cascade;
drop table restaurants cascade;
drop table voted cascade;

create table appuser (
	id varchar(50) primary key,
	password varchar(50),
	name varchar(50),
	age int,
	sex varchar(6),
	phone BIGINT,
	location varchar(50)
);

create table restaurants (
	name varchar(50) primary key,
	elo double precision default 1000,
	wins int default 0,
	losses int default 0,
	ties int default 0,
	vel double precision default 0
);

\copy restaurants(name) from 'restaurants.txt';
UPDATE restaurants set name = replace(name, '''''', '''');

create table voted (
	username varchar(50),
	rest1 varchar(50),
	rest2 varchar(50)
);

