CREATE TABLE categoria(
    id INT AUTO_INCREMENT,
    nombre VARCHAR(20),
    PRIMARY KEY (id)
);

CREATE TABLE producto(
    id INT AUTO_INCREMENT,
    nombre VARCHAR(50),
    precio DOUBLE,
    cantidad INT,
    imagen VARCHAR(255),
    categoria INT,
    descripcion TEXT,
    PRIMARY KEY(id),
    FOREIGN KEY(categoria) REFERENCES categoria(id)
);

CREATE TABLE factura(
    id INT AUTO_INCREMENT,
    fecha DATE,
    cliente BIGINT,
    PRIMARY KEY(id),
    FOREIGN KEY(cliente) REFERENCES users(id)
);

CREATE TABLE compras(
    factura INT,
    producto INT,
    cantidad INT,
    precio DOUBLE,
    PRIMARY KEY(factura, producto),
    FOREIGN KEY(factura) REFERENCES factura(id),
    FOREIGN KEY(producto) REFERENCES producto(id)
);