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
/******/ 	return __webpack_require__(__webpack_require__.s = 45);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/blood_donors/blood_donors.js":
/*!**********************************************************!*\
  !*** ./resources/assets/js/blood_donors/blood_donors.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var tbl = $('#bloodDonorsTable').DataTable({
  processing: true,
  serverSide: true,
  'order': [[4, 'desc']],
  ajax: {
    url: bloodDonorUrl
  },
  columnDefs: [{
    'targets': [5],
    'orderable': false,
    'className': 'text-center',
    'width': '5%'
  }, {
    'targets': [1],
    'className': 'text-right'
  }, {
    targets: '_all',
    defaultContent: 'N/A'
  }],
  columns: [{
    data: 'name',
    name: 'name'
  }, {
    data: 'age',
    name: 'age'
  }, {
    data: function data(row) {
      if (row.gender == 1) return 'Female';else return 'Male';
    },
    name: 'gender'
  }, {
    data: 'blood_group',
    name: 'blood_group'
  }, {
    data: function data(row) {
      return row;
    },
    render: function render(row) {
      if (row.last_donate_date === null) {
        return 'N/A';
      }

      return moment(row.last_donate_date).utc().format('Do MMM, Y h:mm A');
    },
    name: 'last_donate_date'
  }, {
    data: function data(row) {
      var data = [{
        'id': row.id
      }];
      return prepareTemplateRender('#bloodDonorActionTemplate', data);
    },
    name: 'id'
  }]
});
$(document).on('submit', '#addNewForm', function (event) {
  event.preventDefault();
  var loadingButton = jQuery(this).find('#btnSave');
  loadingButton.button('loading');
  $.ajax({
    url: bloodDonorCreateUrl,
    type: 'POST',
    data: $(this).serialize(),
    success: function success(result) {
      if (result.success) {
        displaySuccessMessage(result.message);
        $('#addModal').modal('hide');
        $('#bloodDonorsTable').DataTable().ajax.reload(null, false);
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
$(document).on('submit', '#editForm', function (event) {
  event.preventDefault();
  var loadingButton = jQuery(this).find('#btnEditSave');
  loadingButton.button('loading');
  var id = $('#bloodDonorId').val();
  $.ajax({
    url: bloodDonorUrl + '/' + id,
    type: 'put',
    data: $(this).serialize(),
    success: function success(result) {
      if (result.success) {
        displaySuccessMessage(result.message);
        $('#editModal').modal('hide');
        $('#bloodDonorsTable').DataTable().ajax.reload(null, false);
      }
    },
    error: function error(result) {
      manageAjaxErrors(result);
    },
    complete: function complete() {
      loadingButton.button('reset');
    }
  });
});
$('#addModal').on('hidden.bs.modal', function () {
  resetModalForm('#addNewForm', '#validationErrorsBox');
});
$('#editModal').on('hidden.bs.modal', function () {
  resetModalForm('#editForm', '#editValidationErrorsBox');
});

window.renderData = function (id) {
  $.ajax({
    url: bloodDonorUrl + '/' + id + '/edit',
    type: 'GET',
    success: function success(result) {
      if (result.success) {
        var bloodDonor = result.data;
        $('#bloodDonorId').val(bloodDonor.id);
        $('#editName').val(bloodDonor.name);
        $('#editAge').val(bloodDonor.age);
        $('#male,#female').prop('checked', false);

        if (bloodDonor.gender == 1) {
          $('#female').prop('checked', true);
        } else {
          $('#male').prop('checked', true);
        }

        $('#editBloodGroup').val(bloodDonor.blood_group);
        $('#editBloodGroup').trigger('change');
        $('#editLastDonationDate').val(moment(bloodDonor.last_donate_date).utc().format('YYYY-MM-DD HH:mm:ss'));
        $('#editModal').modal('show');
        ajaxCallCompleted();
      }
    },
    error: function error(result) {
      manageAjaxErrors(result);
    }
  });
};

$(document).on('click', '.edit-btn', function (event) {
  if (ajaxCallIsRunning) {
    return;
  }

  ajaxCallInProgress();
  var bloodDonorId = $(event.currentTarget).data('id');
  renderData(bloodDonorId);
});
$(document).on('click', '.delete-btn', function (event) {
  var bloodDonorId = $(event.currentTarget).data('id');
  deleteItem(bloodDonorUrl + '/' + bloodDonorId, '#bloodDonorsTable', 'Blood Donor');
});
$(document).ready(function () {
  $('#bloodGroup,#editBloodGroup').select2({
    width: '100%'
  });
  $('#lastDonationDate,#editLastDonationDate').datetimepicker(DatetimepickerDefaults({
    format: 'YYYY-MM-DD HH:mm:ss',
    useCurrent: true,
    sideBySide: true,
    maxDate: new Date()
  }));
});

/***/ }),

/***/ 45:
/*!****************************************************************!*\
  !*** multi ./resources/assets/js/blood_donors/blood_donors.js ***!
  \****************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/blood_donors/blood_donors.js */"./resources/assets/js/blood_donors/blood_donors.js");


/***/ })

/******/ });