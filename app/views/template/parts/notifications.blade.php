<script type="text/javascript">
    @if (Session::has('success-notif'))
    $.notify({
        // options
        message: "{{ Session::get('success-notif') }}",
        icon: 'fa fa-success',
    }, {
        // settings
        type: 'success',
        animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
        }

    });
    @elseif(Session::has('warning-notif'))
    $.notify({
        // options
        message: "{{ Session::get('warning-notif') }}",
        icon: 'fa fa-warning',
    }, {
        // settings
        type: 'warning',
        animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
        }

    });
    @elseif(Session::has('info-notif'))
    $.notify({
        // options
        message: "{{ Session::get('info-notif') }}",
        icon: 'fa fa-info',
    }, {
        // settings
        type: 'info',
        animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
        }

    });
    @elseif(Session::has('danger-notif'))
    $.notify({
        // options
        message: "{{ Session::get('danger-notif') }}",
        icon: 'fa fa-warning',
    }, {
        // settings
        type: 'danger',
        animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
        }

    });
    @endif
</script>