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
/******/ 	return __webpack_require__(__webpack_require__.s = 190);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/vaccinated_patients/vaccinated_patients.js":
/*!************************************************************************!*\
  !*** ./resources/assets/js/vaccinated_patients/vaccinated_patients.js ***!
  \************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var tbl = $('#vaccinatedPatientTable').DataTable({
  processing: true,
  serverSide: true,
  'order': [[0, 'desc']],
  ajax: {
    url: vaccinatedPatientUrl
  },
  columnDefs: [{
    'targets': [5],
    'className': 'text-center',
    'orderable': false,
    'width': '5%'
  }, {
    'targets': [3],
    'className': 'text-center',
    'width': '8%'
  }, {
    targets: '_all',
    defaultContent: 'N/A'
  }],
  columns: [{
    data: function data(row) {
      var showLink = patientUrl + '/' + row.patient.id;
      return '<a href="' + showLink + '">' + row.patient.user.full_name + '</a>';
    },
    name: 'patient.user.first_name'
  }, {
    data: 'vaccination.name',
    name: 'vaccination.name'
  }, {
    data: 'vaccination_serial_number',
    name: 'vaccination_serial_number'
  }, {
    data: 'dose_number',
    name: 'dose_number'
  }, {
    data: function data(row) {
      return row;
    },
    render: function render(row) {
      if (row.dose_given_date === null) {
        return 'N/A';
      }

      return moment(row.dose_given_date).utc().format('Do MMM, Y h:mm A');
    },
    name: 'dose_given_date'
  }, {
    data: function data(row) {
      var data = [{
        'id': row.id
      }];
      return prepareTemplateRender('#vaccinationPatientsActionTemplate', data);
    },
    name: 'patient.user.last_name'
  }]
});
$(document).ready(function () {
  $('#patientName,#vaccinationName,#editPatientName,#editVaccinationName').select2({
    width: '100%'
  });
  $('#editDoesGivenDate').datetimepicker(DatetimepickerDefaults({
    format: 'YYYY-MM-DD HH:mm:ss',
    useCurrent: true,
    sideBySide: true,
    maxDate: new Date()
  }));
  $('#doesGivenDate').datetimepicker(DatetimepickerDefaults({
    format: 'YYYY-MM-DD HH:mm:ss',
    useCurrent: true,
    sideBySide: true,
    maxDate: moment().endOf('day'),
    widgetPositioning: {
      horizontal: 'left',
      vertical: 'bottom'
    }
  }));
});
$('#addModal').on('shown.bs.modal', function () {
  $('#doesGivenDate').val(moment().format('YYYY-MM-DD HH:mm:ss'));
});
$(document).on('submit', '#addNewForm', function (event) {
  event.preventDefault();
  var loadingButton = jQuery(this).find('#btnSave');
  loadingButton.button('loading');
  $.ajax({
    url: vaccinatedPatientCreateUrl,
    type: 'POST',
    data: $(this).serialize(),
    success: function success(result) {
      if (result.success) {
        displaySuccessMessage(result.message);
        $('#addModal').modal('hide');
        $('#vaccinatedPatientTable').DataTable().ajax.reload(null, false);
        setTimeout(function () {
          loadingButton.button('reset');
        }, 2500);
      }
    },
    error: function error(result) {
      printErrorMessage('#validationErrorsBox', result);
      setTimeout(function () {
        loadingButton.button('reset');
      }, 2000);
    }
  });
});
$('#addModal').on('hidden.bs.modal', function () {
  $('#patientName').val('').trigger('change');
  $('#vaccinationName').val('').trigger('change');
  $('#doesGivenDate').data('DateTimePicker').date(null);
  resetModalForm('#addNewForm', '#validationErrorsBox');
});
$(document).on('click', '.edit-btn', function (event) {
  if (ajaxCallIsRunning) {
    return;
  }

  ajaxCallInProgress();
  var vaccinatedPatientId = $(event.currentTarget).attr('data-id');
  renderData(vaccinatedPatientId);
});

window.renderData = function (id) {
  $.ajax({
    url: vaccinatedPatientUrl + '/' + id + '/edit',
    type: 'GET',
    success: function success(result) {
      if (result.success) {
        var vaccinatedPatient = result.data;
        console.log(vaccinatedPatient);
        $('#vaccinatedPatientId').val(vaccinatedPatient.id);
        $('#editPatientName').val(vaccinatedPatient.patient_id).trigger('change.select2');
        $('#editVaccinationName').val(vaccinatedPatient.vaccination_id).trigger('change.select2');
        $('#editSerialNo').val(vaccinatedPatient.vaccination_serial_number);
        $('#editDoseNumber').val(vaccinatedPatient.dose_number);
        $('#editDoesGivenDate').val(moment(vaccinatedPatient.dose_given_date).utc().format('YYYY-MM-DD HH:mm:ss'));
        $('#editDescription').val(vaccinatedPatient.description);
        $('#editModal').modal('show');
        ajaxCallCompleted();
      }
    },
    error: function error(result) {
      manageAjaxErrors(result);
    }
  });
};

$(document).on('submit', '#editForm', function (event) {
  event.preventDefault();
  var loadingButton = jQuery(this).find('#editBtnSave');
  loadingButton.button('loading');
  var id = $('#vaccinatedPatientId').val();
  $.ajax({
    url: vaccinatedPatientUrl + '/' + id + '/update',
    type: 'post',
    data: $(this).serialize(),
    success: function success(result) {
      if (result.success) {
        displaySuccessMessage(result.message);
        $('#editModal').modal('hide');
        $('#vaccinatedPatientTable').DataTable().ajax.reload(null, false);
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
$(document).on('click', '.delete-btn', function (event) {
  var vaccinatedPatientId = $(event.currentTarget).data('id');
  deleteItem(vaccinatedPatientUrl + '/' + vaccinatedPatientId, '#vaccinatedPatientTable', 'Vaccinated Patient');
});

/***/ }),

/***/ 190:
/*!******************************************************************************!*\
  !*** multi ./resources/assets/js/vaccinated_patients/vaccinated_patients.js ***!
  \******************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/vaccinated_patients/vaccinated_patients.js */"./resources/assets/js/vaccinated_patients/vaccinated_patients.js");


/***/ })

/******/ });