create database SFA;

use SFA;

create table usuario(
	idUser int(10) unsigned not null auto_increment,
    username varchar(255) not null,
    passwd varchar(255) default null,
    primary key (idUser)
);

create table cargo(
	idCargo int(10) unsigned not null auto_increment,
	funcao varchar(255) not null,
    primary key (idCargo)
);

create table funcionario(
	idFunc int(10) unsigned not null auto_increment,
	idCargo int(10) unsigned not null,
    nome varchar(255) not null,
    rg varchar(255) not null,
    primary key (idFunc),
    foreign key (idCargo) references cargo(idCargo)
);

create table motivo(
	idMotivo int(10) unsigned not null auto_increment,
    motivo varchar(255),
    primary key (idMotivo)
);

create table faltas(
	idFalta int(10) unsigned not null auto_increment,
    idFunc int(10) unsigned not null,
    idMotivo int(10) unsigned not null,
    dia date not null,
    visto int(1) default 0 check(status in (0, 1 , 2)), /* Visto do diretor */
    atrasoMinutos int(2) default null,
    quantidadeAulas int(2) default null,
    quantidadeHaes int(10) default null,
    justificativa varchar(255) default null,
    foreign key (idFunc) references funcionario(idFunc),
    foreign key (idMotivo) references motivo(idMotivo),
    primary key (idFalta)
);

