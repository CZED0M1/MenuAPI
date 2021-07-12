create table meal
(
    id         INTEGER      not null
        primary key autoincrement,
    name       VARCHAR(255) not null,
    price      INTEGER      not null,
    restaurant VARCHAR(255) not null,
    rest_id    int default 2 not null
);


