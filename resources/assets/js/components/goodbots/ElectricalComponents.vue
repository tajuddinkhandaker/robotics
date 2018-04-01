<style scoped>
    .action-link {
        cursor: pointer;
    }
</style>

<template>
    <div>
        <div class="card card-default">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span>
                        Electrical Components
                    </span>

                    <a class="action-link" tabindex="-1" @click="showCreateElectricalComponentForm" title="Create new electrical component">
                        Create New
                    </a>
                </div>
            </div>

            <div class="card-body">
                <!-- Current electrical components -->
                <p class="mb-0" v-if="electricalComponents.length === 0">
                    You have not created any electrical component.
                </p>

                <table class="table table-borderless mb-0" v-if="electricalComponents.length > 0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>State</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="component in electricalComponents">
                            <!-- Name -->
                            <td style="vertical-align: middle;">
                                {{ component.name }}
                            </td>

                            <!-- Type -->
                            <td style="vertical-align: middle;">
                                {{ component.type }}
                            </td>

                            <!-- State -->
                            <td style="vertical-align: middle;">
                               {{ component.state }}
                            </td>

                            <!-- Edit Button -->
                            <td style="vertical-align: middle;">
                                <a class="action-link" tabindex="-1" @click="edit(component)">
                                    Edit
                                </a>
                            </td>

                            <!-- Delete Button -->
                            <td style="vertical-align: middle;">
                                <a class="action-link text-danger" @click="destroy(component)">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create Electrical Component Modal -->
        <div class="modal fade" id="modal-create-electrical-component" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Create Electrical Component
                        </h4>

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <div class="modal-body">
                        <!-- Form Errors -->
                        <div class="alert alert-danger" v-if="createForm.errors.length > 0">
                            <p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                <li v-for="error in createForm.errors">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Create Electrical Component Form -->
                        <form role="form" v-if="botclients.length > 0">
                            <!-- Name -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Name</label>

                                <div class="col-md-9">
                                    <input id="create-electrical-component-name" type="text" class="form-control"
                                                                @keyup.enter="store" v-model="createForm.name" />

                                    <span class="form-text text-muted">
                                        Something that reminds where this component belongs to.
                                    </span>
                                </div>
                            </div>

                            <!-- Type -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Type</label>

                                <div class="col-md-9">
                                    <select class="form-control" v-model="createForm.type">
                                      <option disabled value="">Please select one</option>
                                      <option v-for="component in componentTypes" v-bind:value="component.value">
                                        {{ component.text }}
                                      </option>
                                    </select>

                                    <span class="form-text text-muted">
                                        Your electrical component's genre
                                    </span>
                                </div>
                            </div>

                            <!-- Operational state -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Operation state</label>

                                <div class="col-md-9">
                                    <div v-for="state in operationStates" class="row">
                                        <input type="radio" class="col-md-1"
                                                        v-bind:id="state.value"
                                                        v-bind:value="state.value"
                                                        v-model="createForm.state" />
                                        <label v-bind:for="state.value" class="col-md-2">{{ state.text }}</label>
                                    </div>
                                    <span class="form-text text-muted">
                                        Your electrical component's operational state
                                    </span>
                                </div>
                            </div>

                            <!-- BotClient -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Bot Device</label>

                                <div class="col-md-9">
                                    <select class="form-control" v-model="createForm.bot_id">
                                      <option disabled value="">Please select one</option>
                                      <option v-for="bot in botclients" v-bind:value="bot.id">
                                        {{ bot.name }}
                                      </option>
                                    </select>

                                    <span class="form-text text-muted">
                                        Your device client that you installed.
                                    </span>
                                </div>
                            </div>
                        </form>

                        <!-- Warning message for not having any client device registered -->
                        <p class="mb-0 text-danger" v-if="botclients.length === 0">
                            You have not created any bot client to add components.
                        </p>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                                    v-if="botclients.length > 0">Close</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                                    v-if="botclients.length === 0">Ok</button>

                        <button type="button" class="btn btn-primary" @click="store"
                                                    v-if="botclients.length > 0">
                            Create
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Electrical Component Modal -->
        <div class="modal fade" id="modal-edit-electrical-component" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Edit <label v-model="editForm.name"></label>
                        </h4>

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <div class="modal-body">
                        <!-- Form Errors -->
                        <div class="alert alert-danger" v-if="editForm.errors.length > 0">
                            <p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                <li v-for="error in editForm.errors">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Edit Client Form -->
                        <form role="form">
                            <!-- Name -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Name</label>

                                <div class="col-md-9">
                                    <input id="edit-electrical-component-name" type="text" class="form-control"
                                                                @keyup.enter="update" v-model="editForm.name" />

                                    <span class="form-text text-muted">
                                        Something that reminds where this component belongs to.
                                    </span>
                                </div>
                            </div>

                            <!-- Type -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Type</label>

                                <div class="col-md-9">
                                    <select class="form-control" @keyup.enter="store" v-model="editForm.type">
                                      <option disabled value="">Please select one</option>
                                      <option v-for="component in componentTypes" v-bind:value="component.value">
                                        {{ component.text }}
                                      </option>
                                    </select>

                                    <span class="form-text text-muted">
                                        Your electrical component's genre
                                    </span>
                                </div>
                            </div>

                            <!-- Operational state -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Operation state</label>

                                <div class="col-md-9">
                                    <div v-for="state in operationStates" class="row">
                                        <input type="radio" class="col-md-1"
                                                        v-bind:id="state.value"
                                                        v-bind:value="state.value"
                                                        v-model="editForm.state" />
                                        <label v-bind:for="state.value" class="col-md-2">{{ state.text }}</label>
                                    </div>
                                    <span class="form-text text-muted">
                                        Your electrical component's operational state
                                    </span>
                                </div>
                            </div>

                            <!-- BotClient -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Bot Device</label>

                                <div class="col-md-9">
                                    <select class="form-control" v-model="editForm.bot_id">
                                      <option disabled value="">Please select one</option>
                                      <option v-for="bot in botclients" v-bind:value="bot.id">
                                        {{ bot.name }}
                                      </option>
                                    </select>

                                    <span class="form-text text-muted">
                                        Your device client that you installed.
                                    </span>
                                </div>
                            </div>
                        </form>

                        <!-- Warning message for not having any client device registered -->
                        <p class="mb-0 text-danger" v-if="botclients.length === 0">
                            You have not created any bot client to add components.
                        </p>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                        <button type="button" class="btn btn-primary" @click="update">
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        /*
         * The component's data.
         */
        data() {
            return {
                botclients: [],

                electricalComponents: [],

                operationStates: [
                  { text: 'On', value: 'ON' },
                  { text: 'Off', value: 'OFF' },
                ],

                componentTypes: [
                  { text: 'Light', value: 'LIGHT' },
                  { text: 'Fan', value: 'FAN' },
                ],

                createForm: {
                    errors: [],
                    bot_id: '',
                    profile_id: '',
                    name: '',
                    type: '',
                    state: 'OFF'
                },

                editForm: {
                    errors: [],
                    bot_id: '',
                    profile_id: '',
                    name: '',
                    type: '',
                    state: 'OFF'
                }                
            };
        },

        /**
         * Prepare the component (Vue 1.x).
         */
        ready() {
            this.prepareComponent();
        },

        /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            this.prepareComponent();
        },

        methods: {
            /**
             * Prepare the component.
             */
            prepareComponent() {
                this.getElectricalComponents();
                this.getBotClients();

                $('#modal-create-electrical-component').on('shown.bs.modal', () => {
                    $('#create-electrical-component-name').focus();
                });

                $('#modal-edit-electrical-component').on('shown.bs.modal', () => {
                    $('#edit-electrical-component-name').focus();
                });
            },

            /**
             * Get all of the electrical components for the user.
             */
            getElectricalComponents() {
                axios.get('/api/v1/components')
                        .then(response => {

                            this.electricalComponents = response.data.data;
                        });
            },

            /**
             * Show the form for creating new electrical component.
             */
            showCreateElectricalComponentForm() {
                $('#modal-create-electrical-component').modal('show');
            },

            /**
             * Create a new electrical component for the user.
             */
            store() {
                this.persistElectricalComponents(
                    'post', '/api/v1/components',
                    this.createForm, '#modal-create-electrical-component'
                );
            },

            /**
             * Edit the given electrical component.
             */
            edit(component) {
                this.editForm.id = component.id;
                this.editForm.name = component.name;
                this.editForm.type = component.type;
                this.editForm.state = component.state;
                this.editForm.bot_id = component.bot_id;

                $('#modal-edit-electrical-component').modal('show');
            },

            /**
             * Update the electrical component being edited.
             */
            update() {
                this.persistElectricalComponents(
                    'put', '/api/v1/components/' + this.editForm.id,
                    this.editForm, '#modal-edit-electrical-component'
                );
            },

            /**
             * Persist the electrical components to storage using the given form.
             */
            persistElectricalComponents(method, uri, form, modal) {
                form.errors = [];

                axios[method](uri, form)
                    .then(response => {
                        this.getElectricalComponents();

                        form.bot_id = '';
                        form.name = '';
                        form.type = '';
                        form.state = 'OFF';
                        form.errors = [];

                        $(modal).modal('hide');
                    })
                    .catch(error => {
                        if (typeof error.response.data === 'object') {
                            form.errors = _.flatten(_.toArray(error.response.data.errors));
                        } else {
                            form.errors = ['Something went wrong. Please try again.'];
                        }
                    });
            },

            /**
             * Destroy the given electrical component.
             */
            destroy(component) {
                axios.delete('/api/v1/components/' + component.id)
                        .then(response => {
                            this.getElectricalComponents();
                        });
            },

            /**
             * Get all of the bot clients for the user.
             */
            getBotClients() {
                axios.get('/oauth/clients')
                        .then(response => {
                            this.botclients = response.data;
                        });
            }
        }
    }
</script>
