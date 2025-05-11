import unittest
from app import app, haversine_distance  # Importa la app y las funciones necesarias
import json

class TestApp(unittest.TestCase):
    @classmethod
    def setUpClass(cls):
        # Configura el cliente de pruebas de Flask
        cls.client = app.test_client()

    def test_haversine_distance(self):
        # Prueba la función haversine_distance con puntos conocidos
        coord1 = (19.4326, -99.1332)  # CDMX
        coord2 = (20.6597, -103.3496)  # Guadalajara
        distance = haversine_distance(coord1, coord2)
        expected_distance = 461.1  # Aproximadamente en km
        self.assertAlmostEqual(distance, expected_distance, places=1)

    def test_optimal_route_success(self):
        # Simula una solicitud exitosa al endpoint /optimal_route
        input_data = {
            "points": [
                [19.4326, -99.1332],  # CDMX
                [20.6597, -103.3496],  # Guadalajara
                [21.1619, -86.8515]   # Cancún
            ]
        }
        response = self.client.post('/optimal_route', 
                                    data=json.dumps(input_data), 
                                    content_type='application/json')
        self.assertEqual(response.status_code, 200)
        response_data = response.get_json()
        self.assertIn('route', response_data)
        self.assertEqual(len(response_data['route']), len(input_data['points']) + 1)

    def test_optimal_route_no_points(self):
        # Simula una solicitud al endpoint sin datos
        response = self.client.post('/optimal_route', 
                                    data=json.dumps({}), 
                                    content_type='application/json')
        self.assertEqual(response.status_code, 400)
        response_data = response.get_json()
        self.assertIn('error', response_data)
        self.assertEqual(response_data['error'], 'No points provided')

    def test_optimal_route_single_point(self):
        # Prueba con solo un punto
        input_data = {"points": [[19.4326, -99.1332]]}
        response = self.client.post('/optimal_route', 
                                    data=json.dumps(input_data), 
                                    content_type='application/json')
        self.assertEqual(response.status_code, 200)
        response_data = response.get_json()
        self.assertEqual(response_data['route'], [[19.4326, -99.1332], [19.4326, -99.1332]])

if __name__ == '__main__':
    unittest.main()
