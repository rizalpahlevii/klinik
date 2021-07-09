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
/******/ 	return __webpack_require__(__webpack_require__.s = 79);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/investigation_reports/investigation_reports.js":
/*!****************************************************************************!*\
  !*** ./resources/assets/js/investigation_reports/investigation_reports.js ***!
  \****************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var tableName = '#investigationReportTable';
var tbl = $('#investigationReportTable').DataTable({
  processing: true,
  serverSide: true,
  'order': [[1, 'desc']],
  ajax: {
    url: investigationReportUrl,
    data: function data(_data) {
      _data.status = $('#filter_status').find('option:selected').val();
    }
  },
  columnDefs: [{
    'targets': [4, 5],
    'className': 'text-center'
  }, {
    'targets': [6],
    'orderable': false,
    'className': 'text-center',
    'width': '5%'
  }, {
    targets: '_all',
    defaultContent: 'N/A'
  }, {
    'targets': [7, 8],
    'visible': false
  }],
  columns: [{
    data: function data(row) {
      var showLink = patientUrl + '/' + row.patient.id;
      return '<a href="' + showLink + '">' + row.patient.user.full_name + '</a>';
    },
    name: 'patient.user.first_name'
  }, {
    data: function data(row) {
      return row;
    },
    render: function render(row) {
      if (row.date === null) {
        return 'N/A';
      }

      return moment(row.date).format('Do MMM, Y h:mm A');
    },
    name: 'date'
  }, {
    data: function data(row) {
      var showLink = investigationReportUrl + '/' + row.id;
      return '<a href="' + showLink + '">' + row.title + '</a>';
    },
    name: 'title'
  }, {
    data: function data(row) {
      var showLink = doctorUrl + '/' + row.doctor.id;
      return '<a href="' + showLink + '">' + row.doctor.user.full_name + '</a>';
    },
    name: 'doctor.user.first_name'
  }, {
    data: function data(row) {
      if (row.status == 1) return 'Solved';else return 'Not Solved';
    },
    name: 'status'
  }, {
    data: function data(row) {
      if (row.attachment_url != null) {
        var downloadLink = downloadDocumentUrl + '/' + row.id;
        return '<a href="' + downloadLink + '">' + 'Download' + '</a>';
      } else {
        return 'N/A';
      }
    },
    name: 'id'
  }, {
    data: function data(row) {
      var url = investigationReportUrl + '/' + row.id;
      var data = [{
        'id': row.id,
        'url': url + '/edit'
      }];
      return prepareTemplateRender('#investigationReportActionTemplate', data);
    },
    name: 'id'
  }, {
    data: 'patient.user.last_name',
    name: 'patient.user.last_name'
  }, {
    data: 'doctor.user.last_name',
    name: 'doctor.user.last_name'
  }],
  'fnInitComplete': function fnInitComplete() {
    $('#filter_status').change(function () {
      $(tableName).DataTable().ajax.reload(null, true);
    });
  }
});
$(document).on('click', '.delete-btn', function (event) {
  var investigationReportId = $(event.currentTarget).data('id');
  deleteItem(investigationReportUrl + '/' + investigationReportId, '#investigationReportTable', 'Investigation Report');
});

/***/ }),

/***/ 79:
/*!**********************************************************************************!*\
  !*** multi ./resources/assets/js/investigation_reports/investigation_reports.js ***!
  \**********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/investigation_reports/investigation_reports.js */"./resources/assets/js/investigation_reports/investigation_reports.js");


/***/ })

/******/ });