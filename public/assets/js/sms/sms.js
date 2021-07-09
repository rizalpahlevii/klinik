/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 132);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/sms/sms.js":
/*!****************************************!*\
  !*** ./resources/assets/js/sms/sms.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  'use strict';

  $('#userId, #roleId').select2({
    width: '100%'
  });
  var tableName = '#smsTable';
  var tbl = $(tableName).DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: smsUrl
    },
    columnDefs: [{
      'targets': [3],
      'orderable': false,
      'className': 'text-center',
      'width': '10%'
    }, {
      targets: '_all',
      defaultContent: 'N/A'
    }, {
      'targets': [4],
      'visible': false
    }],
    columns: [{
      data: function data(row) {
        var showLink = smsUrl + '/' + row.id;

        if (row.user != null) {
          return '<a href="' + showLink + '">' + row.user.full_name + '</a>';
        } else {
          return 'N/A';
        }
      },
      name: 'user.first_name'
    }, {
      data: function data(row) {
        return isEmpty(row.region_code) ? row.phone_number : '+' + row.region_code + row.phone_number;
      },
      name: 'phone_number'
    }, {
      data: 'send_by.full_name',
      name: 'sendBy.first_name'
    }, {
      data: function data(row) {
        var data = [{
          'id': row.id
        }];
        return prepareTemplateRender('#smsTemplate', data);
      },
      name: 'id'
    }, {
      data: 'send_by.last_name',
      name: 'sendBy.last_name'
    }]
  });
  $('#messageId').keypress(function (e) {
    var tval = $('#messageId').val(),
        tlength = tval.length,
        set = 160,
        remain = parseInt(set - tlength);

    if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
      $('#messageId').val(tval.substring(0, tlength - 1));
      $('#validationErrorsBox').html('The message may not be greater than 160 characters.').show();
    }
  });
  $(document).on('submit', '#addNewForm', function (event) {
    event.preventDefault();
    var loadingButton = jQuery(this).find('#btnSave');
    loadingButton.button('loading');

    if ($('#number').is(':checked')) {
      $('#roleId').remove();
      $('#userId').remove();
    }

    $.ajax({
      url: createSmsUrl,
      type: 'POST',
      data: $(this).serialize(),
      success: function success(result) {
        if (result.success) {
          displaySuccessMessage(result.message);
          $('#AddModal').modal('hide');
          tbl.ajax.reload();
        }
      },
      error: function error(result) {
        printErrorMessage('#validationErrorsBox', result);
      },
      complete: function complete() {
        loadingButton.button('reset');
      }
    });
  });
  $(document).on('click', '.delete-btn', function (event) {
    var id = $(event.currentTarget).data('id');
    deleteItem(smsUrl + '/' + id, tableName, 'SMS');
  });
  $('#AddModal').on('hidden.bs.modal', function () {
    resetModalForm('#addNewForm', '#validationErrorsBox');
    $('#userId').val('').trigger('change.select2');
    $('#roleId').val('').trigger('change.select2');
    hide();
  });
  $('.myclass').hide();
  $('#phoneNumber').prop('required', false);
  $(document).on('click', '.number', function () {
    if ($('.number').is(':checked')) {
      $('.myclass').show();
      $('.number').attr('value', 1);
      $('.role').hide();
      $('#roleId').prop('required', false);
      $('.send').hide();
      $('#userId').prop('required', false);
    } else {
      hide();
    }
  });

  function hide() {
    $('.myclass').hide();
    $('.number').attr('value', 0);
    $('.role').show();
    $('.send').show();
  }
});
$('#roleId').on('change', function () {
  if ($(this).val() !== '') {
    $.ajax({
      url: getUsersListUrl,
      type: 'get',
      dataType: 'json',
      data: {
        id: $(this).val()
      },
      success: function success(data) {
        $('#userId').empty();
        $('#userId').removeAttr('disabled');
        $.each(data.data, function (i, v) {
          $('#userId').append($('<option></option>').attr('value', i).text(v));
        });
      }
    });
  }

  $('#userId').empty();
  $('#userId').prop('disabled', true);
});

/***/ }),

/***/ 132:
/*!**********************************************!*\
  !*** multi ./resources/assets/js/sms/sms.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/sms/sms.js */"./resources/assets/js/sms/sms.js");


/***/ })

/******/ });