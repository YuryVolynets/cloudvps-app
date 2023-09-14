import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import 'flowbite';

import jQuery from 'jquery';

window.$ = jQuery;

$('#createButton').on('click', function () {
    $.ajax({
        type: 'GET',
        url: '/links/create',
        dataType: 'json',
        success: function (response) {
            $('#modalTitle').text(response.title);
            $('#modalBody').html(response.body);

            $('#modalEditForm').on('submit', function (event) {
                event.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function () {
                        window.location.replace('/links');
                    },
                    error: function (response) {
                        $('.error').text('');
                        $.each(response.responseJSON.errors, function (id, errors) {
                            $('#' + id + '_error').text(errors[0]);
                        })
                    }
                });
            });
        },
        error: function (request) {
            console.log('Ajax call went wrong: ' + request.responseText);
        }
    });
});

$('.editButton').on('click', function () {
    $.ajax({
        type: 'GET',
        url: '/links/' + $(this).data('id') + '/edit',
        dataType: 'json',
        success: function (response) {
            $('#modalTitle').text(response.title);
            $('#modalBody').html(response.body);

            $('#modalEditForm').on('submit', function (event) {
                event.preventDefault();

                $.ajax({
                    type: 'PATCH',
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function () {
                        window.location.replace('/links');
                    },
                    error: function (response) {
                        $('.error').text('');
                        $.each(response.responseJSON.errors, function (id, errors) {
                            $('#' + id + '_error').text(errors[0]);
                        })
                    }
                });
            });
        },
        error: function (request) {
            console.log('Ajax call went wrong: ' + request.responseText);
        }
    });
});

$('.deleteButton').on('click', function () {
    $('#modalDeleteForm').attr('action', 'links/' + $(this).data('id'));
});
