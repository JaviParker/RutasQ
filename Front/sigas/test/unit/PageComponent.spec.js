import { mount } from '@vue/test-utils';
import PageComponent from 'src/components/PageComponent.vue'; // Ruta del componente
import { api } from 'src/boot/axios'; // Mockear Axios

jest.mock('src/boot/axios', () => ({
  api: {
    get: jest.fn(),
  },
}));

describe('PageComponent.vue', () => {
  let wrapper;

  beforeEach(() => {
    wrapper = mount(PageComponent, {
      mocks: {
        $router: {
          push: jest.fn(),
        },
      },
    });
  });

  afterEach(() => {
    jest.clearAllMocks();
  });

  it('debería renderizar correctamente los ingresos del día', async () => {
    api.get.mockResolvedValueOnce({ data: { totalIngresos: 1200 } });
    await wrapper.vm.obtenerIngresosDia();
    expect(wrapper.vm.ingresosDia).toBe(1200);
    expect(api.get).toHaveBeenCalledWith('/ingresos-del-dia');
  });

  it('debería obtener los ingresos por día y actualizar los datos', async () => {
    const ingresosMock = [{ dia: '2024-12-19', total: 500 }];
    api.get.mockResolvedValueOnce({ data: ingresosMock });
    await wrapper.vm.obtenerIngresosPorDia();
    expect(wrapper.vm.ingresosPorDia).toEqual(ingresosMock);
    expect(api.get).toHaveBeenCalledWith('/ingresos-por-dia');
  });

  it('debería redirigir al registro de clientes al hacer clic en el botón', async () => {
    const mockRouterPush = wrapper.vm.$router.push;
    wrapper.vm.redirectToRegister();
    expect(mockRouterPush).toHaveBeenCalledWith({ name: 'adminCheckUsers' });
  });

  it('debería mostrar el texto correcto en la página', () => {
    expect(wrapper.text()).toContain('Ingresos del dia');
  });

  it('debería mostrar el botón de "Revisar inventario"', () => {
    const button = wrapper.find('q-btn[label="Revisar inventario"]');
    expect(button.exists()).toBe(true);
  });

  it('debería mostrar el botón de "Registrar cliente"', () => {
    const button = wrapper.find('q-btn[label="Registrar cliente"]');
    expect(button.exists()).toBe(true);
  });
});
