@extends('layouts.app')
@section('content')
    <div id="app">

        <div class="container mt-5">
            <div class="row">
                <div class="col-12">
                    <h2>Job Vacancies</h2>
                    <div class="col-md-12 text-right"> <!-- Adjust the column size as needed -->
                        <button class="btn btn-primary" v-on:click="popupModal(0)">Add New Job</button>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(vacancy,index) in vacancyList">
                                <tr>
                                    <td>@{{ (pagination.per_page * (pagination.current_page - 1)) + index + 1 }}</td>
                                    <td>@{{ vacancy.job.job_name }}</td>
                                    <td>@{{ vacancy.start_date }} to @{{ vacancy.end_date }}</td>
                                    <td>
                                        <span v-if="vacancy.status == 'Active'"
                                            class="text-success">@{{ vacancy.status }}</span>
                                        <span v-else class="text-danger">@{{ vacancy.status }}</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-success mr-2" v-on:click="popupModal(vacancy)">Edit</button>
                                        <button class="btn btn-danger"
                                            v-on:click="deleteVacancy(vacancy.id)">Delete</button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
                {{-- pagination --}}
                <nav aria-label="pagination">
                    <ul class="pagination justify-content-end">
                        <li class="page-item" v-if="pagination.current_page > 1">
                            <a class="page-link" href="#" aria-label="Previous"
                                @click.prevent="changePage(pagination.current_page - 1)">
                                <span aria-hidden="true">«</span>
                            </a>
                        </li>
                        <li class="page-item" v-for="page in pagesNumber"
                            v-bind:class="[ page == isActived ? 'active' : '']">
                            <a class="page-link" href="#" @click.prevent="changePage(page)">@{{ page }}</a>
                        </li>
                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                            <a class="page-link" href="#" aria-label="Next"
                                @click.prevent="changePage(pagination.current_page + 1)">
                                <span aria-hidden="true">»</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                {{-- end --}}
            </div>

        </div>

        {{-- Modal --}}
        <modal name="addEditJobModal" width="850" height="auto" :scrollable="true" :adaptive="true"
            :resizable="true" style="padding:10px">
            <div class="modal-header" style="padding: 10px">

                <h4 class="modal-title" id="modelHeading">@{{ modelHeading }}</h4>
                <button class="close" type="button" v-on:click="hide" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

            </div>
            <div class="modal-body" style="padding: 15px">
                <form @submit.prevent="validateBeforeSubmit" v-if="!formSubmitted" method="post">
                    <div class="row">
                        <div class="col-md-3 col-sm-12 form-group">
                            <label for="start_date" class="form-label"><strong>Start Date</strong></label>
                            <input type="date" class="form-control" v-model="start_date" placeholder="Start Date"
                                v-validate.initial="start_date" data-rules="required">
                            <span v-if="formErrors['start_date']" class="error text-danger">@{{ formErrors['start_date'] }}</span>
                            <p class="text-danger" v-if="errors.has('start_date')">@{{ errors.first('start_date') }}</p>
                        </div>

                        <div class="col-md-3 col-sm-12 form-group">
                            <label for="end_date" class="form-label"><strong>End Date</strong></label>
                            <input type="date" class="form-control" v-model="end_date" placeholder="End Date"
                                v-validate.initial="end_date" data-rules="required">
                            <span v-if="formErrors['end_date']" class="error text-danger">@{{ formErrors['end_date'] }}</span>
                            <p class="text-danger" v-if="errors.has('end_date')">@{{ errors.first('end_date') }}</p>
                        </div>

                        <div class="col-md-3 col-sm-12 form-group">
                            <label for="job" class="form-label"><strong>Job</strong></label>
                            <select v-model="job" class="form-control" v-validate.initial="job" data-rules="required">
                                <option value="" selected>-Select-</option>
                                <option v-for="job in jobs" :value="job.id">@{{ job.job_name }}</option>
                            </select>
                            <span v-if="formErrors['job']" class="error text-danger">@{{ formErrors['job'] }}</span>
                            <p class="text-danger" v-if="errors.has('job')">@{{ errors.first('job') }}</p>
                        </div>

                        <div class="col-md-3 col-sm-12 form-group">
                            <label for="status" class="form-label"><strong>Status</strong></label>
                            <select v-model="status" class="form-control" v-validate.initial="status"
                                data-rules="required">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                            <span v-if="formErrors['status']" class="error text-danger">@{{ formErrors['status'] }}</span>
                            <p class="text-danger" v-if="errors.has('status')">@{{ errors.first('status') }}</p>
                        </div>

                        <div class="col-md-12 col-sm-12 form-group">
                            <label for="description" class="form-label"><strong>Description</strong></label>
                            <textarea class="form-control" v-model="description" rows="3" placeholder="Description"></textarea>
                        </div>

                        <div class="modal-footer mt-3" style="gap: 5px">
                            <button class="btn btn-primary" type="button" v-on:click="hide">Cancel</button>
                            <button type="submit" class="btn btn-success"
                                v-bind:disabled="submit_button_flag">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </modal>


    </div>
    <script>
        Vue.use(window["vue-js-modal"].default);
        var app = new Vue({
            el: '#app',

            data: {

                loading: false,

                base_url: "{{ url('/') }}",

                vacancyList: [],
                jobs: [],
                start_date: '',
                end_date: '',
                job: '',
                status: '',
                description: '',
                modelHeading: '',

                //
                formSubmitted: false,
                submit_button_flag: false,
                search: '',
                page_length: '10',

                pagination: {
                    total: 0,
                    per_page: 2,
                    from: 1,
                    to: 0,
                    current_page: 1
                },
                offset: 4,
                formErrors: {},
            },

            //

            computed: {
                isActived: function() {
                    return app.pagination.current_page;
                },
                pagesNumber: function() {
                    if (!this.pagination.to) {
                        return [];
                    }
                    var from = this.pagination.current_page - this.offset;
                    if (from < 1) {
                        from = 1;
                    }
                    var to = from + (this.offset * 2);
                    if (to >= this.pagination.last_page) {
                        to = this.pagination.last_page;
                    }
                    var pagesArray = [];
                    while (from <= to) {
                        pagesArray.push(from);
                        from++;
                    }
                    return pagesArray;
                }
            },

            //

            methods: {

                validateBeforeSubmit(e) {
                    console.log(this.errors);
                    this.$validator.validateAll();
                    if (!this.errors.any()) {
                        this.submitForm()
                    }
                },
                submitForm() {
                    // this.formSubmitted = true
                    this.addEditSubmitForm()
                },

                changePage: function(page) {
                    this.pagination.current_page = page;
                    app.getJobVacancyList(page);
                },

                handleChangePage(e) {
                    console.log(this.page_length)
                    app.getJobVacancyList();
                },

                // show modal
                show: function() {
                    app.$modal.show('addEditJobModal');
                },

                // close modal
                hide: function() {
                    app.$modal.hide('addEditJobModal');
                },


                addEditSubmitForm: function() {

                    app.submit_button_flag = true;
                    url = "api/job-vacancy/store";

                    axios.post(url, {
                        "start_date": this.start_date,
                        "end_date": this.end_date,
                        "job_id": this.job,
                        "status": this.status,
                        "description": this.description,
                        "vacancy_id": this.vacancy_id,

                    }).then(function(response) {

                        app.submit_button_flag = false;
                        console.log(response);
                        if (response.data.errorcode == 0) {
                            app.loading = false;
                            Vue.$toast.success(response.data.errormessage, 'Success Alert');
                            app.formSubmitted = true;
                            app.formErrors = {};

                            app.$modal.hide('addEditJobModal');
                            app.getJobVacancyList(app.pagination.current_page);
                        } else {
                            app.loading = false;
                            Vue.$toast.error('Something went wrong.', 'Danger Alert');

                            app.$modal.hide('addEditJobModal');
                            app.getJobVacancyList();
                        }

                    }).catch(function(err) {
                        app.submit_button_flag = false;
                        console.log(err.response);
                        console.log(err.response.data.errors);
                        app.formErrors = err.response.data.errors;

                    });

                },

                popupModal: function(data) {

                    if (data.id > 0) {

                        app.start_date = data.start_date;
                        app.end_date = data.end_date;
                        app.job = data.job_id;
                        app.status = data.status;
                        app.description = data.description;
                        app.vacancy_id = data.id;


                        app.formSubmitted = false;
                        app.formErrors = {};
                        app.modelHeading = "Edit Job Vacancy";
                        app.$modal.show('addEditJobModal');
                    } else {
                        app.start_date = '';
                        app.end_date = '';
                        app.job = '';
                        app.status = 'Active';
                        app.description = '';
                        app.vacancy_id = '';


                        app.formSubmitted = false;
                        app.formErrors = {};

                        app.modelHeading = "Add Job Vacancy";

                        app.$modal.show('addEditJobModal');
                    }
                },
                deleteVacancy: function(vacancyId) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: '',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // If confirmed, send delete request
                            let url = "api/job-vacancy/delete/"+vacancyId;
                            axios.delete(url).then(function(response) {
                                // Handle success response
                                Swal.fire(
                                    'Deleted!',
                                    'Vacancy has been deleted.',
                                    'success'
                                );
                                app.getJobVacancyList(app.pagination.current_page);
                            }).catch(function(error) {
                                // Handle error response
                                Swal.fire(
                                    'Error!',
                                    'Failed to delete vacancy.',
                                    'error'
                                );
                                console.error('Delete error:', error);
                            });
                        }
                    });
                },
                getJobVacancyList: function(page = 1) {

                    url = "api/job-vacancy/list";
                    axios.post(url, {
                        "page": page,
                        "page_length": this.page_length,
                    }).then(function(response) {
                        app.vacancyList = response.data.data.data.data;
                        app.pagination = response.data.data.pagination;

                        app.loading = false;
                    });
                },
                getJobList: function(page = 1) {

                    url = "api/get-jobs";
                    axios.get(url, {}).then(function(response) {
                        app.jobs = response.data.data;
                        app.loading = false;
                    });
                },

            },
            mounted() {
                this.getJobVacancyList();
                this.getJobList();
            }
        });
    </script>
@endsection
