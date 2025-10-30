 <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    Adicionar Novo Estágio de Contato
                </h2>

                <form method="POST" action="{{ route('estagio.de.contato.create') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="nicho" class="block text-sm font-medium text-gray-700">Estágio de Contato</label>
                        <input type="text" name="estagio-contato" id="c" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="flex justify-end">
                        <x-secondary-button type="button" @click="$dispatch('close-modal', 'modal-add-estagio-de-contato')" class="mr-2">
                            {{ __('Cancelar') }}
                        </x-secondary-button>
                       <x-primary-button type="submit">
                            {{ __('Salvar') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>