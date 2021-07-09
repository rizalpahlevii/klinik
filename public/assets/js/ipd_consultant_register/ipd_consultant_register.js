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
/******/ 	return __webpack_require__(__webpack_require__.s = 154);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/ipd_consultant_register/ipd_consultant_register.js":
/*!********************************************************************************!*\
  !*** ./resources/assets/js/ipd_consultant_register/ipd_consultant_register.js ***!
  \********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  'use strict';

  var tableName = '#tblIpdConsultantRegisters';
  $(tableName).DataTable({
    processing: true,
    serverSide: true,
    'order': [[0, 'desc']],
    ajax: {
      url: ipdConsultantRegisterUrl,
      data: function data(_data) {
        _data.id = ipdPatientDepartmentId;
      }
    },
    columnDefs: [{
      'targets': [0, 1, 2],
      'width': '10%'
    }, {
      'targets': [3],
      'className': 'text-center',
      'orderable': false,
      'width': '4%'
    }, {
      targets: '_all',
      defaultContent: 'N/A'
    }],
    columns: [{
      data: function data(row) {
        return row;
      },
      render: function render(row) {
        if (row.applied_date === null) {
          return 'N/A';
        }

        return moment(row.applied_date).format('Do MMM, Y h:mm A');
      },
      name: 'applied_date'
    }, {
      data: function data(row) {
        var showLink = doctorUrl + '/' + row.doctor_id;
        return '<a href="' + showLink + '">' + row.doctor.user.full_name + '</a>';
      },
      name: 'doctor.user.first_name'
    }, {
      data: function data(row) {
        return row;
      },
      render: function render(row) {
        if (row.instruction_date === null) {
          return 'N/A';
        }

        return moment(row.instruction_date).format('Do MMM, Y');
      },
      name: 'instruction_date'
    }, {
      data: function data(row) {
        var data = [{
          'id': row.id
        }];
        return prepareTemplateRender('#ipdConsultantRegisterActionTemplate', data);
      },
      name: 'doctor.user.last_name'
    }]
  });

  var addDateTimePicker = function addDateTimePicker() {
    $('.appliedDate').datetimepicker(DatetimepickerDefaults({
      format: 'YYYY-MM-DD HH:mm:ss',
      useCurrent: false,
      sideBySide: true,
      widgetPositioning: {
        horizontal: 'left',
        vertical: 'bottom'
      },
      minDate: ipdPatientCaseDate
    }));
    $('.instructionDate').datetimepicker(DatetimepickerDefaults({
      format: 'YYYY-MM-DD',
      useCurrent: false,
      sideBySide: true,
      widgetPositioning: {
        horizontal: 'left',
        vertical: 'bottom'
      },
      minDate: ipdPatientCaseDate
    }));
  };

  addDateTimePicker();

  var dropdownToSelect2 = function dropdownToSelect2(selector) {
    $(selector).select2({
      placeholder: 'Select Doctor',
      width: '100%'
    });
  };

  dropdownToSelect2('.doctorId');
  $(document).on('click', '#addItem', function () {
    var data = {
      'doctors': doctors,
      'uniqueId': uniqueId
    };
    var ipdConsultantItemHtml = prepareTemplateRender('#ipdConsultantInstructionItemTemplate', data);
    $('.ipd-consultant-item-container').append(ipdConsultantItemHtml);
    dropdownToSelect2('.doctorId');
    addDateTimePicker();
    uniqueId++;
    resetIpdConsultantItemIndex();
  });

  var resetIpdConsultantItemIndex = function resetIpdConsultantItemIndex() {
    var index = 1;
    $('.ipd-consultant-item-container>tr').each(function () {
      $(this).find('.item-number').text(index);
      index++;
    });

    if (index - 1 == 0) {
      var data = {
        'doctors': doctors,
        'uniqueId': uniqueId
      };
      var ipdConsultantItemHtml = prepareTemplateRender('#ipdConsultantInstructionItemTemplate', data);
      $('.ipd-consultant-item-container').append(ipdConsultantItemHtml);
      dropdownToSelect2('.doctorId');
      uniqueId++;
    }
  };

  $(document).on('click', '.deleteIpdConsultantInstruction', function () {
    $(this).parents('tr').remove();
    resetIpdConsultantItemIndex();
  });
  $(document).on('click', '.delete-consultant-btn', function (event) {
    var id = $(event.currentTarget).data('id');
    deleteItem(ipdConsultantRegisterUrl + '/' + id, tableName, 'IPD Consultant Instruction');
  });
  $(document).on('submit', '#addIpdConsultantNewForm', function (event) {
    event.preventDefault();
    var loadingButton = jQuery(this).find('#btnIpdConsultantSave');
    loadingButton.button('loading');
    var data = {
      'formSelector': $(this),
      'url': ipdConsultantRegisterCreateUrl,
      'type': 'POST',
      'tableSelector': tableName
    };
    newRecord(data, loadingButton, '#addConsultantInstructionModal');
  });
  $(document).on('click', '.edit-consultant-btn', function (event) {
    if (ajaxCallIsRunning) {
      return;
    }

    ajaxCallInProgress();
    var ipdConsultantId = $(event.currentTarget).data('id');
    renderConsultantData(ipdConsultantId);
  });

  window.renderConsultantData = function (id) {
    $.ajax({
      url: ipdConsultantRegisterUrl + '/' + id + '/edit',
      type: 'GET',
      success: function success(result) {
        if (result.success) {
          $('#ipdEditConsultantId').val(result.data.id);
          $('#ipdEditAppliedDate').val(result.data.applied_date);
          $('#editDoctorId').val(result.data.doctor_id).trigger('change.select2');
          $('#editInstructionDate').val(result.data.instruction_date);
          $('#editConsultantInstruction').val(result.data.instruction);
          $('#editIpdConsultantInstructionModal').modal('show');
          ajaxCallCompleted();
        }
      },
      error: function error(result) {
        manageAjaxErrors(result);
      }
    });
  };

  $(document).on('submit', '#editIpdConsultantNewForm', function (event) {
    event.preventDefault();
    var loadingButton = jQuery(this).find('#btnEditIpdConsultantSave');
    loadingButton.button('loading');
    var id = $('#ipdEditConsultantId').val();
    var url = ipdConsultantRegisterUrl + '/' + id;
    var data = {
      'formSelector': $(this),
      'url': url,
      'type': 'POST',
      'tableSelector': tableName
    };
    editRecord(data, loadingButton, '#editIpdConsultantInstructionModal');
  });
  $('#addConsultantInstructionModal').on('hidden.bs.modal', function () {
    resetModalForm('#addIpdConsultantNewForm', '#validationErrorsBox');
    $('#ipdConsultantInstructionTbl').find('tr:gt(1)').remove();
    $('.doctorId').val('');
    $('.doctorId').trigger('change');
  });
});

/***/ }),

/***/ 154:
/*!**************************************************************************************!*\
  !*** multi ./resources/assets/js/ipd_consultant_register/ipd_consultant_register.js ***!
  \**************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/ipd_consultant_register/ipd_consultant_register.js */"./resources/assets/js/ipd_consultant_register/ipd_consultant_register.js");


/***/ })

/******/ });