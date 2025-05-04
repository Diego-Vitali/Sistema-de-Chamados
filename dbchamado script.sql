DROP DATABASE IF EXISTS dbchamados;

create database dbchamados;
use dbchamados;


create table tbusu(
	id int primary key auto_increment,
	nome char(55),
	telefone int unique,
	email char(55) unique,
	senha char(55),
	funcao char (30)
);

create table tbchamado(
	cod int primary key auto_increment,
	idCliente int,
	descricao char(150),
	statusChamado char (50),
	categoria char(50),
	telefoneContato int,
	dataCriacao date,
	CONSTRAINT fk_idCliente FOREIGN KEY (idCliente) REFERENCES tbUsu(id)
);
select * from tbchamado;
