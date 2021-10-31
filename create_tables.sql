CREATE TABLE form(
	id serial not null PRIMARY KEY,
	system_user_id integer not null,
	name VARCHAR(50) NOT NULL,
	path TEXT NOT NULL,
	dt_creation TIMESTAMP without time zone default now(),
	dt_update TIMESTAMP without time zone default now()
);

CREATE TABLE page(
	id serial not null PRIMARY KEY,
	system_user_id integer not null,
	name VARCHAR(50) NOT NULL,
	path TEXT NOT NULL,
	dt_creation TIMESTAMP without time zone default now(),
	dt_update TIMESTAMP without time zone default now()
);

CREATE TABLE system_user_pages(
	id serial not null PRIMARY KEY,
	page_id INTEGER NOT NULL,
	system_user_id INTEGER NOT NULL,
	readonly boolean not null default false,
	FOREIGN KEY (page_id) REFERENCES page(id)
);

CREATE TABLE system_group_pages(
	id serial not null PRIMARY KEY,
	page_id INTEGER NOT NULL,
	system_group_id INTEGER NOT NULL,
	readonly boolean not null default false,
	FOREIGN KEY (page_id) REFERENCES page(id)
);

CREATE TABLE page_forms(
	id serial not null PRIMARY KEY,
	page_id INTEGER NOT NULL,
	form_id INTEGER NOT NULL,
	FOREIGN KEY (page_id) REFERENCES page(id),
	FOREIGN KEY (form_id) REFERENCES form(id)
);

CREATE TABLE class(
	id serial not null PRIMARY KEY,
	system_user_id integer not null,
	name VARCHAR(50) not null,
	path VARCHAR(50) not null,
	dt_creation TIMESTAMP without time zone default now()
);