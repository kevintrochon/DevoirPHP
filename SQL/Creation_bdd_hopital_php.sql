-- Création de la base de données "hopital_php".
CREATE DATABASE hopital_php DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

-- Utilisation de la base créée.
USE hopital_php;

-- Création des différentes tables : Patients, Pays, Motifs, Sexe.

CREATE TABLE Pays 
(
	codePays char(2) primary key,
    Libelle varchar(100)
);

CREATE TABLE Motifs 
(
	CodeMotifs int primary key auto_increment,
    Libelle varchar(100)
);

CREATE TABLE Sexe 
(
	CodeSexe char(1) primary key,
    libelle varchar(50)
);

CREATE TABLE Patients 
(
	CodePatients int primary key auto_increment,
	Nom varchar(50),
    Prenom varchar(50),
    Sexe char(1),
    DateNaissance date DEFAULT '00/00/0000',
    NumeroSecSoc varchar(100),
    CodePays char(2),
    Date1Entree date,
    CodeMotif int,
    foreign key (CodeMotif) REFERENCES Motifs(CodeMotifs)
);

CREATE TABLE Documents
(
	ged varchar(255) primary key,
    namePatient varchar(255),
    name varchar(255),
    path varchar(150),
    contenu varchar(255),
    typeDocument varchar(5),
    CodePatients int,
    CodeMotif int,
    foreign key (CodeMotif) REFERENCES Motifs(CodeMotifs),
    foreign key (CodePatients) REFERENCES Patients(CodePatients)
);

-- Création de l'utilisateur user1 avec le password hcetylop.
DROP user if exists 'user1'@'localhost';
CREATE USER 'user1'@'localhost' IDENTIFIED BY 'hcetylop';

-- Accord de tous les droits sur la base de données.
GRANT ALL PRIVILEGES ON hopital_php.* TO 'user1'@'localhost';
FLUSH PRIVILEGES;

-- Insertion des données dans les différentes tables : Patients, Pays, Motifs, Sexe.

INSERT INTO Patients (Nom,Prenom,Sexe ,DateNaissance ,NumeroSecSoc ,CodePays ,Date1Entree,CodeMotif) VALUES('MAALOUL', 'Ali','M',CAST('1979-01-12'AS date),'','TN',CAST('2018-02-01' AS date),1);
INSERT INTO Patients (Nom,Prenom,Sexe ,DateNaissance ,NumeroSecSoc ,CodePays ,Date1Entree,CodeMotif) VALUES('DUPONT', 'Véronique','F',CAST('1938-12-27'AS date),'238277502900442','FR',CAST('2018-04-05'AS date),2);
INSERT INTO Patients (Nom,Prenom,Sexe ,DateNaissance ,NumeroSecSoc ,CodePays ,Date1Entree,CodeMotif) VALUES('DUPONT', 'Jean','M',CAST('1985-04-01'AS date),'185045903800855','FR',CAST('2018-06-12'AS date),3);
INSERT INTO Patients (Nom,Prenom,Sexe ,DateNaissance ,NumeroSecSoc ,CodePays ,Date1Entree,CodeMotif) VALUES('EL GUERROUJ', 'Hicham','M',CAST('1980-06-10'AS date),'','MA',CAST('2018-08-18'AS date),1);
INSERT INTO Patients (Nom,Prenom,Sexe ,DateNaissance ,NumeroSecSoc ,CodePays ,Date1Entree,CodeMotif) VALUES('BELMADI', 'Djamel','M',CAST('1982-12-27'AS date),'','DZ',CAST('2018-09-26'AS date),1);

INSERT INTO Pays (CodePays, Libelle) VALUES ('FR','France');
INSERT INTO Pays (CodePays, Libelle) VALUES ('BE','Belgique');
INSERT INTO Pays (CodePays, Libelle) VALUES ('MA','Maroc');
INSERT INTO Pays (CodePays, Libelle) VALUES ('TN','Tunisie');
INSERT INTO Pays (CodePays, Libelle) VALUES ('DZ','Algérie');

INSERT INTO Motifs (Libelle) VALUES('Consultation libre');
INSERT INTO Motifs (Libelle) VALUES('Urgence');
INSERT INTO Motifs (Libelle) VALUES('Prescription');

INSERT INTO Sexe (CodeSexe, Libelle) VALUES ('F','Féminin');
INSERT INTO Sexe (CodeSexe, Libelle) VALUES ('M','Masculin');

INSERT INTO documents(ged,namePatient, name, path, contenu, typeDocument, CodePatients, CodeMotif) VALUES('pdfattestation1attestation reussite L3 TK.pdfMAALOULAli','MAALOUL','attestation reussite L3 TK.pdf','D:/wamp64/www/Devoir/upload/attestation reussite L3 TK.pdf','attestation','pdf',1,1);
INSERT INTO documents(ged,namePatient, name, path, contenu, typeDocument, CodePatients, CodeMotif) VALUES('pdfinstruction2instruction_utilisation.pdfMAALOULAli', 'MAALOUL', 'instruction_utilisation.pdf', 'D:/wamp64/www/Devoir/upload/instructions_utilisation.pdf', 'instruction', 'pdf', '1', '2');
INSERT INTO documents(ged,namePatient, name, path, contenu, typeDocument, CodePatients, CodeMotif) VALUES('pdfattestation1attestation reussite L3 TK.pdfDUPONTVéronique','DUPONT','attestation reussite L3 TK.pdf','D:/wamp64/www/Devoir/upload/attestation reussite L3 TK.pdf','attestation','pdf',2,1);
INSERT INTO documents(ged,namePatient, name, path, contenu, typeDocument, CodePatients, CodeMotif) VALUES('pdfinstruction2instruction_utilisation.pdfDUPONTVéronique', 'DUPONT', 'instruction_utilisation.pdf', 'D:/wamp64/www/Devoir/upload/instructions_utilisation.pdf', 'instruction', 'pdf', '2', '2');
INSERT INTO documents(ged,namePatient, name, path, contenu, typeDocument, CodePatients, CodeMotif) VALUES('pdfattestation1attestation reussite L3 TK.pdfDUPONTJean','DUPONT','attestation reussite L3 TK.pdf','D:/wamp64/www/Devoir/upload/attestation reussite L3 TK.pdf','attestation','pdf',3,1);
INSERT INTO documents(ged,namePatient, name, path, contenu, typeDocument, CodePatients, CodeMotif) VALUES('pdfinstruction2instruction_utilisation.pdfDUPONTJean', 'DUPONT', 'instruction_utilisation.pdf', 'D:/wamp64/www/Devoir/upload/instructions_utilisation.pdf', 'instruction', 'pdf',3, '2');
INSERT INTO documents(ged,namePatient, name, path, contenu, typeDocument, CodePatients, CodeMotif) VALUES('pdfattestation1attestation reussite L3 TK.pdEL GUERROUJfHicham','EL GUERROUJ','attestation reussite L3 TK.pdf','D:/wamp64/www/Devoir/upload/attestation reussite L3 TK.pdf','attestation','pdf',4,1);
INSERT INTO documents(ged,namePatient, name, path, contenu, typeDocument, CodePatients, CodeMotif) VALUES('pdfinstruction2instruction_utilisation.pdfEL GUERROUJHicham', 'EL GUERROUJ', 'instruction_utilisation.pdf', 'D:/wamp64/www/Devoir/upload/instructions_utilisation.pdf', 'instruction', 'pdf',4, '2');
INSERT INTO documents(ged,namePatient, name, path, contenu, typeDocument, CodePatients, CodeMotif) VALUES('pdfattestation1attestation reussite L3 TK.pdfBELMADIDjamel','BELMADI','attestation reussite L3 TK.pdf','D:/wamp64/www/Devoir/upload/attestation reussite L3 TK.pdf','attestation','pdf',5,1);
INSERT INTO documents(ged,namePatient, name, path, contenu, typeDocument, CodePatients, CodeMotif) VALUES('pdfinstruction2instruction_utilisation.pdfBELMADIDjamel', 'BELMADI', 'instruction_utilisation.pdf', 'D:/wamp64/www/Devoir/upload/instructions_utilisation.pdf', 'instruction', 'pdf',5, '2');