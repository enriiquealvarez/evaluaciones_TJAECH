-- database/schema.sql
CREATE DATABASE IF NOT EXISTS tjaech_eval CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tjaech_eval;

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(120) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    last_login_at DATETIME NULL,
    created_at DATETIME NOT NULL
) ENGINE=InnoDB;

CREATE TABLE admin_roles (
    admin_id INT NOT NULL,
    role ENUM('ADMIN','COURSES','EVALUATIONS','RESULTS','USERS') NOT NULL,
    PRIMARY KEY (admin_id, role),
    FOREIGN KEY (admin_id) REFERENCES admins(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE admin_password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT NOT NULL,
    token_hash VARCHAR(255) NOT NULL,
    expires_at DATETIME NOT NULL,
    used_at DATETIME NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (admin_id) REFERENCES admins(id) ON DELETE CASCADE,
    INDEX idx_admin_resets_admin (admin_id),
    INDEX idx_admin_resets_expires (expires_at)
) ENGINE=InnoDB;

CREATE TABLE cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(160) NOT NULL,
    descripcion TEXT NULL,
    fecha_inicio DATE NULL,
    fecha_fin DATE NULL,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL
) ENGINE=InnoDB;

CREATE TABLE evaluaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    curso_id INT NOT NULL,
    titulo VARCHAR(160) NOT NULL,
    descripcion TEXT NULL,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (curso_id) REFERENCES cursos(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE preguntas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    evaluacion_id INT NOT NULL,
    texto VARCHAR(500) NOT NULL,
    tipo ENUM('opcion','likert','si_no','abierta') NOT NULL,
    requerido TINYINT(1) NOT NULL DEFAULT 0,
    orden INT NOT NULL,
    FOREIGN KEY (evaluacion_id) REFERENCES evaluaciones(id) ON DELETE CASCADE,
    INDEX idx_preguntas_eval (evaluacion_id)
) ENGINE=InnoDB;

CREATE TABLE opciones_pregunta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pregunta_id INT NOT NULL,
    texto VARCHAR(200) NOT NULL,
    valor VARCHAR(200) NOT NULL,
    es_correcta TINYINT(1) NOT NULL DEFAULT 0,
    orden INT NOT NULL,
    FOREIGN KEY (pregunta_id) REFERENCES preguntas(id) ON DELETE CASCADE,
    INDEX idx_opciones_pregunta (pregunta_id)
) ENGINE=InnoDB;

CREATE TABLE respuestas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    curso_id INT NOT NULL,
    evaluacion_id INT NOT NULL,
    folio VARCHAR(40) NOT NULL UNIQUE,
    nombre_completo VARCHAR(160) NOT NULL,
    correo VARCHAR(120) NULL,
    telefono VARCHAR(30) NULL,
    municipio VARCHAR(120) NOT NULL,
    cargo_puesto VARCHAR(160) NOT NULL,
    comentarios TEXT NULL,
    ip VARCHAR(45) NULL,
    user_agent VARCHAR(180) NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (curso_id) REFERENCES cursos(id) ON DELETE CASCADE,
    FOREIGN KEY (evaluacion_id) REFERENCES evaluaciones(id) ON DELETE CASCADE,
    INDEX idx_respuestas_curso (curso_id)
) ENGINE=InnoDB;

CREATE TABLE respuestas_detalle (
    id INT AUTO_INCREMENT PRIMARY KEY,
    respuesta_id INT NOT NULL,
    pregunta_id INT NOT NULL,
    valor_texto TEXT NULL,
    valor_opcion VARCHAR(200) NULL,
    valor_num INT NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (respuesta_id) REFERENCES respuestas(id) ON DELETE CASCADE,
    FOREIGN KEY (pregunta_id) REFERENCES preguntas(id) ON DELETE CASCADE,
    INDEX idx_detalle_respuesta (respuesta_id)
) ENGINE=InnoDB;
