-- Creamos la tabla "Categorías"
CREATE TABLE Categorías (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(255) NOT NULL
);

-- Creamos la tabla "Productos"
CREATE TABLE Productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(255) NOT NULL,
    Precio DECIMAL(10, 2) NOT NULL,
    Imagen VARCHAR(255),
    Categoría INT,
    FOREIGN KEY (Categoría) REFERENCES Categorías(Id)
);