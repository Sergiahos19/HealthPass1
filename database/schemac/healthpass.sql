-- Schema MySQL importable dans XAMPP pour HealthPass.
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS JOURNAL_AUDIT, RESULTAT_SERVICE, FORMAT, CONSULTATION, RENDEZ_VOUS, DOCTEUR, SERVICE, UTILISATEUR, ROLE, PATIENT, ETABLISSEMENT;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE ETABLISSEMENT (
  id_etablissement VARCHAR(42) NOT NULL,
  nom_etablissement VARCHAR(150) NOT NULL,
  adresse VARCHAR(255) NOT NULL,
  telephone VARCHAR(30), email_etablissement VARCHAR(255), numero_ifu VARCHAR(30) NOT NULL,
  est_approuve BOOLEAN NOT NULL DEFAULT FALSE,
  PRIMARY KEY (id_etablissement), UNIQUE KEY uq_etablissement_ifu (numero_ifu)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE ROLE (
  id_role VARCHAR(42) NOT NULL, libelle_role VARCHAR(42) NOT NULL,
  PRIMARY KEY (id_role), UNIQUE KEY uq_role_libelle (libelle_role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE PATIENT (
  id_patient VARCHAR(42) NOT NULL, npi VARCHAR(42), nom VARCHAR(100), prenom VARCHAR(100), sexe VARCHAR(20),
  date_naissance DATE, email VARCHAR(255), telephone VARCHAR(30), empreinte_digitale VARCHAR(255),
  PRIMARY KEY (id_patient), UNIQUE KEY uq_patient_npi (npi), UNIQUE KEY uq_patient_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE UTILISATEUR (
  id_user VARCHAR(42) NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, email VARCHAR(255) NOT NULL,
  mot_de_passe VARCHAR(255) NOT NULL, id_role VARCHAR(42) NOT NULL, id_etablissement VARCHAR(42),
  PRIMARY KEY (id_user), UNIQUE KEY uq_utilisateur_email (email),
  CONSTRAINT fk_utilisateur_role FOREIGN KEY (id_role) REFERENCES ROLE (id_role),
  CONSTRAINT fk_utilisateur_etablissement FOREIGN KEY (id_etablissement) REFERENCES ETABLISSEMENT (id_etablissement)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE DOCTEUR (
  id_docteur VARCHAR(42) NOT NULL, nom VARCHAR(100), prenom VARCHAR(100), specialite VARCHAR(100), telephone VARCHAR(30),
  email VARCHAR(255), mot_de_passe VARCHAR(255), id_etablissement VARCHAR(42) NOT NULL, PRIMARY KEY (id_docteur),
  CONSTRAINT fk_docteur_etablissement FOREIGN KEY (id_etablissement) REFERENCES ETABLISSEMENT (id_etablissement)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE SERVICE (
  id_service VARCHAR(42) NOT NULL, nom_service VARCHAR(100), type_service VARCHAR(100), telephone VARCHAR(30),
  email VARCHAR(255), id_etablissement VARCHAR(42) NOT NULL, PRIMARY KEY (id_service),
  CONSTRAINT fk_service_etablissement FOREIGN KEY (id_etablissement) REFERENCES ETABLISSEMENT (id_etablissement)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE CONSULTATION (
  id_consultation VARCHAR(42) NOT NULL, date_consultation DATE, heure TIME, motif TEXT, symptomes TEXT, diagnostic TEXT,
  traitement TEXT, observation_medicale TEXT, id_patient VARCHAR(42) NOT NULL, id_docteur VARCHAR(42) NOT NULL,
  PRIMARY KEY (id_consultation), CONSTRAINT fk_consultation_patient FOREIGN KEY (id_patient) REFERENCES PATIENT (id_patient),
  CONSTRAINT fk_consultation_docteur FOREIGN KEY (id_docteur) REFERENCES DOCTEUR (id_docteur)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE RENDEZ_VOUS (
  id_rdv VARCHAR(42) NOT NULL, date_rdv DATE, heure_rdv TIME, motif TEXT, statut VARCHAR(42), id_patient VARCHAR(42) NOT NULL,
  PRIMARY KEY (id_rdv), CONSTRAINT fk_rdv_patient FOREIGN KEY (id_patient) REFERENCES PATIENT (id_patient)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE FORMAT (
  id_format VARCHAR(42) NOT NULL, libelle_format VARCHAR(100), type_examen VARCHAR(100), observation TEXT, id_service VARCHAR(42) NOT NULL,
  PRIMARY KEY (id_format), CONSTRAINT fk_format_service FOREIGN KEY (id_service) REFERENCES SERVICE (id_service)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE RESULTAT_SERVICE (
  id_resultat VARCHAR(42) NOT NULL, date_resultat DATE, fichier_pdf VARCHAR(255), statut VARCHAR(42),
  id_consultation VARCHAR(42) NOT NULL, id_format VARCHAR(42) NOT NULL, PRIMARY KEY (id_resultat),
  CONSTRAINT fk_resultat_consultation FOREIGN KEY (id_consultation) REFERENCES CONSULTATION (id_consultation),
  CONSTRAINT fk_resultat_format FOREIGN KEY (id_format) REFERENCES FORMAT (id_format)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE JOURNAL_AUDIT (
  id_audit VARCHAR(42) NOT NULL, action VARCHAR(255), date_action DATE, heure_action TIME, adresse_ip VARCHAR(45), id_user VARCHAR(42) NOT NULL,
  PRIMARY KEY (id_audit), CONSTRAINT fk_audit_user FOREIGN KEY (id_user) REFERENCES UTILISATEUR (id_user)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO ROLE (id_role, libelle_role) VALUES ('role-admin', 'administrateur'), ('role-service', 'service');
INSERT INTO ETABLISSEMENT (id_etablissement, nom_etablissement, adresse, email_etablissement, numero_ifu, est_approuve)
VALUES ('etab-demo', 'Etablissement de demonstration', 'Cotonou', 'contact@healthpass.test', 'IFU-DEMO-001', TRUE);
-- Identifiants de test: admin@healthpass.test / Admin@12345
INSERT INTO UTILISATEUR (id_user, nom, prenom, email, mot_de_passe, id_role, id_etablissement)
VALUES ('user-admin-demo', 'Administrateur', 'Demo', 'admin@healthpass.test', '$2y$12$5i2it1ypBCGG9HsPGb6W5u7XYPK6JSgbGgrtuph.EGkIQjJOShL6K', 'role-admin', 'etab-demo');
