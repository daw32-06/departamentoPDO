
create database `jjrDBdepartamento`;
use `jjrDBdepartamento`;

CREATE TABLE `Departamento` (
  `codDepartamento` VARCHAR(3) NOT NULL,
  `descDepartamento` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`codDepartamento`));

GRANT ALL PRIVILEGES ON jjrDBdepartamento.* TO 'usDepartamento'@'%' IDENTIFIED BY 'paso';
