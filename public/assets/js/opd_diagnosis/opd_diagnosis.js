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
/******/ 	return __webpack_require__(__webpack_require__.s = 171);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/opd_diagnosis/opd_diagnosis.js":
/*!************************************************************!*\
  !*** ./resources/assets/js/opd_diagnosis/opd_diagnosis.js ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  'use strict';

  var tableName = '#tblOpdDiagnoses';
  $(tableName).DataTable({
    processing: true,
    serverSide: true,
    'order': [[1, 'desc']],
    ajax: {
      url: opdDiagnosisUrl,
      data: function data(_data) {
        _data.id = opdPatientDepartmentId;
      }
    },
    columnDefs: [{
      'targets': [0, 1, 2],
      'width': '10%'
    }, {
      'targets': [3],
      'width': '20%'
    }, {
      'targets': [4],
      'className': 'text-center',
      'orderable': false,
      'width': '4%'
    }, {
      targets: '_all',
      defaultContent: 'N/A'
    }],
    columns: [{
      data: 'report_type',
      name: 'report_type'
    }, {
      data: function data(row) {
        return row;
      },
      render: function render(row) {
        if (row.report_date === null) {
          return 'N/A';
        }

        return moment(row.report_date).format('Do MMM, Y h:mm A');
      },
      name: 'report_date'
    }, {
      data: function data(row) {
        if (row.opd_diagnosis_document_url != '') {
          var downloadLink = downloadDiagnosisDocumentUrl + '/' + row.id;
          return '<a href="' + downloadLink + '">' + 'Download' + '</a>';
        } else return 'N/A';
      },
      name: 'description'
    }, {
      data: 'description',
      name: 'description'
    }, {
      data: function data(row) {
        var data = [{
          'id': row.id
        }];
        return prepareTemplateRender('#opdDiagnosisActionTemplate', data);
      },
      name: 'id'
    }]
  });
  $('#reportDate, #editReportDate').datetimepicker(DatetimepickerDefaults({
    format: 'YYYY-MM-DD',
    useCurrent: true,
    sideBySide: true,
    minDate: moment(appointmentDate).format('YYYY-MM-DD'),
    widgetPositioning: {
      horizontal: 'left',
      vertical: 'bottom'
    }
  }));
  $(document).on('click', '.delete-btn', function (event) {
    var id = $(event.currentTarget).data('id');
    deleteItem(opdDiagnosisUrl + '/' + id, tableName, 'OPD Diagnosis');
  });
  $(document).on('submit', '#addNewForm', function (event) {
    event.preventDefault();
    var loadingButton = jQuery(this).find('#btnSave');
    loadingButton.button('loading');
    var data = {
      'formSelector': $(this),
      'url': opdDiagnosisCreateUrl,
      'type': 'POST',
      'tableSelector': tableName
    };
    newRecord(data, loadingButton, '#addModal');
  });
  $(document).on('click', '.edit-btn', function (event) {
    if (ajaxCallIsRunning) {
      return;
    }

    ajaxCallInProgress();
    var opdDiagnosisId = $(event.currentTarget).data('id');
    renderData(opdDiagnosisId);
  });

  window.renderData = function (id) {
    $.ajax({
      url: opdDiagnosisUrl + '/' + id + '/edit',
      type: 'GET',
      success: function success(result) {
        if (result.success) {
          var ext = result.data.opd_diagnosis_document_url.split('.').pop().toLowerCase();

          if (ext == 'pdf') {
            $('#editPreviewImage').attr('src', pdfDocumentImageUrl);
          } else if (ext == 'docx' || ext == 'doc') {
            $('#editPreviewImage').attr('src', docxDocumentImageUrl);
          } else {
            if (result.data.opd_diagnosis_document_url != '') {
              $('#editPreviewImage').attr('src', result.data.opd_diagnosis_document_url);
            }
          }

          $('#opdDiagnosisId').val(result.data.id);
          $('#editReportType').val(result.data.report_type);
          $('#editReportDate').val(result.data.report_date);
          $('#editDescription').val(result.data.description);

          if (result.data.opd_diagnosis_document_url != '') {
            $('#documentUrl').show();
            $('#documentUrl').attr('href', result.data.opd_diagnosis_document_url);
          } else {
            $('#documentUrl').hide();
          }

          $('#EditModal').modal('show');
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
    var loadingButton = jQuery(this).find('#btnEditSave');
    loadingButton.button('loading');
    var id = $('#opdDiagnosisId').val();
    var url = opdDiagnosisUrl + '/' + id;
    var data = {
      'formSelector': $(this),
      'url': url,
      'type': 'POST',
      'tableSelector': tableName
    };
    editRecord(data, loadingButton);
  });
  $('#addModal').on('hidden.bs.modal', function () {
    resetModalForm('#addNewForm', '#validationErrorsBox');
    $('#previewImage').attr('src', defaultDocumentImageUrl);
  });
  $('#editModal').on('hidden.bs.modal', function () {
    resetModalForm('#editForm', '#editValidationErrorsBox');
  });
});
$(document).on('change', '#documentImage', function () {
  var extension = isValidDocument($(this), '#validationErrorsBox');

  if (!isEmpty(extension) && extension != false) {
    $('#validationErrorsBox').html('').hide();
    displayDocument(this, '#previewImage', extension);
  }
});
$(document).on('change', '#editDocumentImage', function () {
  var extension = isValidDocument($(this), '#editValidationErrorsBox');

  if (!isEmpty(extension) && extension != false) {
    $('#editValidationErrorsBox').html('').hide();
    displayDocument(this, '#editPreviewImage', extension);
  }
});

window.isValidDocument = function (inputSelector, validationMessageSelector) {
  var ext = $(inputSelector).val().split('.').pop().toLowerCase();

  if ($.inArray(ext, ['png', 'jpg', 'jpeg', 'pdf', 'doc', 'docx']) == -1) {
    $(inputSelector).val('');
    $(validationMessageSelector).html('The document must be a file of type: jpeg, jpg, png, pdf, doc, docx.').show();
    return false;
  }

  return ext;
};

/***/ }),

/***/ 171:
/*!******************************************************************!*\
  !*** multi ./resources/assets/js/opd_diagnosis/opd_diagnosis.js ***!
  \******************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/opd_diagnosis/opd_diagnosis.js */"./resources/assets/js/opd_diagnosis/opd_diagnosis.js");


/***/ })

/******/ });