
USE db_document;

CREATE TABLE documents (
    id INT(11) NOT NULL AUTO_INCREMENT,
    document_type VARCHAR(50) NOT NULL,
    document_title VARCHAR(255) NOT NULL,
    document_author VARCHAR(100) NOT NULL,
    document_date DATE NOT NULL,
    document_file VARCHAR(255) NOT NULL,
    document_file_path VARCHAR(255),
    PRIMARY KEY (id)
);
