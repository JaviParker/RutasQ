# Importación de bibliotecas necesarias
import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
import seaborn as sns

# Para modelado predictivo
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestRegressor
from sklearn.metrics import mean_squared_error, r2_score

# Para optimización de rutas
import networkx as nx
from scipy.spatial import distance

# Para manejo de advertencias
import warnings
warnings.filterwarnings("ignore")

# Carga de datos de ventas y rutas
ventas_df = pd.read_csv('ventas.csv')  # Archivo con datos de ventas históricas
rutas_df = pd.read_csv('rutas.csv')    # Archivo con datos de rutas y ubicaciones

# Visualización inicial
print("Datos de ventas:")
print(ventas_df.head())
print("\nDatos de rutas:")
print(rutas_df.head())

# Limpieza de datos de ventas
ventas_df.dropna(inplace=True)
ventas_df['fecha'] = pd.to_datetime(ventas_df['fecha'])
ventas_df['mes'] = ventas_df['fecha'].dt.month
ventas_df['dia_semana'] = ventas_df['fecha'].dt.weekday

# Limpieza de datos de rutas
rutas_df.dropna(inplace=True)
rutas_df['coordenadas'] = rutas_df[['latitud', 'longitud']].apply(tuple, axis=1)

# Mapeo de categorías a valores numéricos
ventas_df['categoria'] = ventas_df['categoria'].astype('category').cat.codes

# Análisis de ventas por producto
sns.barplot(data=ventas_df, x='producto', y='ventas')
plt.title('Ventas por Producto')
plt.xticks(rotation=45)
plt.show()

# Visualización de rutas
plt.figure(figsize=(10, 6))
sns.scatterplot(data=rutas_df, x='latitud', y='longitud', hue='zona')
plt.title('Mapa de Zonas')
plt.show()

# Variables independientes y dependientes
X = ventas_df[['categoria', 'mes', 'dia_semana']]
y = ventas_df['ventas']

# División de datos en entrenamiento y prueba
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# Entrenamiento del modelo
modelo = RandomForestRegressor(n_estimators=100, random_state=42)
modelo.fit(X_train, y_train)

# Predicción y evaluación
predicciones = modelo.predict(X_test)
print("MSE:", mean_squared_error(y_test, predicciones))
print("R2:", r2_score(y_test, predicciones))

# Importancia de características
importancias = pd.DataFrame({'Característica': X.columns, 'Importancia': modelo.feature_importances_})
print("\nImportancia de características:\n", importancias.sort_values(by='Importancia', ascending=False))

# Creación del grafo de rutas
grafo = nx.Graph()

# Agregar nodos (ubicaciones)
for index, row in rutas_df.iterrows():
    grafo.add_node(row['id'], pos=(row['latitud'], row['longitud']))

# Calcular distancias y agregar aristas
nodos = list(grafo.nodes(data=True))
for i, nodo1 in enumerate(nodos):
    for j, nodo2 in enumerate(nodos):
        if i < j:
            distancia = distance.euclidean(nodo1[1]['pos'], nodo2[1]['pos'])
            grafo.add_edge(nodo1[0], nodo2[0], weight=distancia)

# Visualización del grafo
pos = nx.get_node_attributes(grafo, 'pos')
nx.draw(grafo, pos, with_labels=True, node_size=500, node_color="skyblue")
plt.title('Red de Rutas')
plt.show()

# Resolver el problema del vendedor viajero
ruta_optima = nx.approximation.traveling_salesman_problem(grafo, cycle=True)
print("\nRuta óptima:", ruta_optima)

def predecir_productos(mes, dia_semana, categoria):
    entrada = np.array([[categoria, mes, dia_semana]])
    prediccion = modelo.predict(entrada)
    return prediccion[0]

def sugerir_ruta():
    print("\nRuta sugerida para la entrega:")
    print(" -> ".join(map(str, ruta_optima)))

# Ejemplo de uso
print("\nProducto más vendido estimado:", predecir_productos(mes=12, dia_semana=5, categoria=1))
sugerir_ruta()
