

create databse webcrawller;
use webcraller;

create table resultado_jogos (
    
id_resultado int primary key auto_increment not null unique,
informacao varchar(200),
data_captura datetime ,
data_alteracao datetime
);