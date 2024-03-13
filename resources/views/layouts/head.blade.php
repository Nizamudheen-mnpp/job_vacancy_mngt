{{-- Vue Js Script --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{ asset('assets/vuejs/dist/vue.js') }}"></script>

<script src="{{ asset('assets/vuejs/axios/axios.min.js') }}"></script>
<script src="{{ asset('assets/vuejs/ajax/libs/moment.min.js') }}"></script>

{{-- multiselect --}}
<link href="{{ asset('assets/vuejs/multi_select/vue-multiselect.min.css') }}" rel="stylesheet">
<script src="{{ asset('assets/vuejs/multi_select/vue-multiselect.min.js') }}"></script>

{{-- toast-text-data --}}
<link href="{{ asset('assets/vuejs/toast/vue_toast.css') }}" rel="stylesheet">
<script src="{{ asset('assets/vuejs/toast/vue_toast.js') }}"></script>

<!-- Init the plugin -->
<script>
    Vue.use(VueToast, {
        position: "top-right",
        duration: 5000,
        dismissible: true
    })
</script>

{{-- validation --}}
<script src="{{ asset('assets/vuejs/vee_validate/veeValidate.js') }}"></script>
<script>
    Vue.use(VeeValidate);
</script>

<script>
    Vue.component("vue-multiselect", window.VueMultiselect.default);
</script>


{{-- <script src="{{ asset('assets/vuejs/vue_moment/vue-moment.min.js') }}"></script>
  <script>Vue.use(vueMoment); Vue.use(moment);</script> --}}

{{-- Infinite scroll --}}
<script src="{{ asset('assets/vuejs/infinite_scroll/vue-infinite-scroll.js') }}"></script>
{{-- modal --}}
<script src="{{ asset('assets/vuejs/dist/vue-js-modal.js?11') }}"></script>

{{-- vue  end --}}

<script src="{{ asset('assets/admin/js/axios_rest_client_service.js') }}"></script>


<script>
    function showLoader() {
        document.getElementById('loader').style.display = 'block';
        document.getElementById('content1').style.display = 'none';
    }

    function hideLoader() {
        document.getElementById('loader').style.display = 'none';
        document.getElementById('content1').style.display = 'block';
    }
</script>
