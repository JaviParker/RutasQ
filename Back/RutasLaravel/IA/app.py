from flask import Flask, request, jsonify
from math import radians, sin, cos, sqrt, atan2
from flask_cors import CORS

app = Flask(__name__)
CORS(app)

@app.route('/optimal_route', methods=['POST'])
def optimal_route():
    data = request.json
    points = data.get('points')  # Coordenadas recibidas
    if not points:
        return jsonify({'error': 'No points provided'}), 400

    start = points[0]  # Punto inicial
    remaining = points[1:]  # Resto de los puntos
    route = [start]
    current = start

    while remaining:
        # Calcula la distancia al punto más cercano
        nearest = min(remaining, key=lambda p: haversine_distance(current, p))
        route.append(nearest)
        remaining.remove(nearest)
        current = nearest

    # Cierra la ruta volviendo al inicio
    route.append(start)
    return jsonify({'route': route})

def haversine_distance(coord1, coord2):
    # Calcula la distancia entre dos puntos (lat, lon)
    R = 6371  # Radio de la Tierra en km
    lat1, lon1 = radians(coord1[0]), radians(coord1[1])
    lat2, lon2 = radians(coord2[0]), radians(coord2[1])
    dlat, dlon = lat2 - lat1, lon2 - lon1
    a = sin(dlat / 2)**2 + cos(lat1) * cos(lat2) * sin(dlon / 2)**2
    c = 2 * atan2(sqrt(a), sqrt(1 - a))
    return R * c

if __name__ == '__main__':
    app.run(debug=True)
