CREATE DATABASE "lazynb";
\c lazynb;

CREATE TABLE IF NOT EXISTS "clients" (
	"id" serial NOT NULL UNIQUE,
	"name" varchar(100) NOT NULL,
	"cpf" varchar(11) NOT NULL UNIQUE,
	"phone_number" varchar(11) NOT NULL,
	"email" varchar(150) NOT NULL UNIQUE,
	PRIMARY KEY ("id")
);

CREATE TABLE IF NOT EXISTS "collaborators" (
	"id" serial NOT NULL UNIQUE,
	"name" varchar(100) NOT NULL,
	"cpf" varchar(11) NOT NULL UNIQUE,
	"phone_number" varchar(11) NOT NULL,
	"email" varchar(150) NOT NULL UNIQUE,
	"is_admin" boolean NOT NULL DEFAULT '0',
	"password" varchar(200),
	PRIMARY KEY ("id")
);

CREATE TABLE IF NOT EXISTS "properties" (
	"id" serial NOT NULL UNIQUE,
	"name" varchar(100) NOT NULL,
	"cep" varchar(8) NOT NULL,
	"neighborhood" varchar(100) NOT NULL,
	"address_number" varchar(5) NOT NULL,
	"complement" varchar(200) NOT NULL,
	"city" varchar(100) NOT NULL,
	"uf" varchar(2) NOT NULL,
	"description" varchar(250) NOT NULL,
	"clientid" bigint NOT NULL,
	PRIMARY KEY ("id")
);

CREATE TABLE IF NOT EXISTS "amenities" (
	"id" serial NOT NULL UNIQUE,
	"name" varchar(100) NOT NULL,
	PRIMARY KEY ("id")
);

CREATE TABLE IF NOT EXISTS "properties_amenities" (
	"id" serial NOT NULL UNIQUE,
	"propertyid" bigint NOT NULL,
	"amenityid" bigint NOT NULL,
	PRIMARY KEY ("id")
);

CREATE TABLE IF NOT EXISTS "user_code" (
	"id" serial NOT NULL UNIQUE,
	"verification_code" varchar(8) NOT NULL,
	"user_id" bigint NOT NULL UNIQUE,
	PRIMARY KEY ("id")
);



ALTER TABLE "properties" ADD CONSTRAINT "properties_fk9" FOREIGN KEY ("clientid") REFERENCES "clients"("id");

ALTER TABLE "properties_amenities" ADD CONSTRAINT "properties_amenities_fk1" FOREIGN KEY ("propertyid") REFERENCES "properties"("id");

ALTER TABLE "properties_amenities" ADD CONSTRAINT "properties_amenities_fk2" FOREIGN KEY ("amenityid") REFERENCES "amenities"("id");
ALTER TABLE "user_code" ADD CONSTRAINT "user_code_fk2" FOREIGN KEY ("user_id") REFERENCES "collaborators"("id");

INSERT INTO "collaborators" (
	"name"
	, "cpf"
	, "phone_number"
	, "email"
	, "is_admin"
	, "password"
) VALUES (
	'Admin'
	, '12345678910'
	, '11999999999'
	, 'admin@email.com'
	, true
	, '$2y$15$Lw5oOOWfJall2AUykHR6ouiV268mScEJtC.z7U.V7OjNgCysWAJie'
);

INSERT INTO "amenities" (
	"name"
) VALUES (
	'Balcony'
), (
	'Garage'
), (
	'Garden'
), (
	'Pool'
);
