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
/******/ 	return __webpack_require__(__webpack_require__.s = 13);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/suppliers/suppliers_data_listing.js":
/*!*****************************************************************!*\
  !*** ./resources/assets/js/suppliers/suppliers_data_listing.js ***!
  \*****************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var tableName2 = "#salesmansTbl";
var tbl2 = $("#salesmansTbl").DataTable({
  processing: true,
  serverSide: true,
  searching: false,
  paging: false,
  ajax: {
    url: salesmanUrl,
    data: function data(_data) {
      _data.status = $("#filter_status").find("option:selected").val();
    }
  },
  columnDefs: [{
    targets: "_all",
    defaultContent: "N/A"
  }],
  columns: [{
    data: "salesman_name",
    name: "salesman_name"
  }, {
    data: "phone",
    name: "phone"
  }, {
    data: function data(row) {
      var url = salesmanUrl + "/" + row.id;
      var data = [{
        id: row.id,
        url: url + "/edit"
      }];
      return "<a title=\"Hapus\" class=\"btn action-btn btn-danger btn-sm sales-delete-btn\" data-id=\"".concat(row.id, "\">\n                <i class=\"fa fa-trash action-icon\"></i>\n                </a>");
    },
    name: "id"
  }],
  fnInitComplete: function fnInitComplete() {
    $("#filter_status").change(function () {
      $(tableName2).DataTable().ajax.reload(null, true);
    });
  }
});
$(document).on("click", ".sales-delete-btn", function (event) {
  var salesmanId = $(event.currentTarget).data("id");
  deleteItem(salesmanUrl + "/" + "salesmans/" + salesmanId, "#salesmansTbl", "Saleman");
});
$(".btn-save-salesman").click(function () {
  if ($("#salesman_name").val() == "" || $("#salesman_phone").val() == "") {
    alert("Nama sales atau telpn masih kosong");
    return;
  }

  $.ajax({
    url: salesmanUrl + "/" + "salesmans",
    method: "post",
    dataType: "json",
    data: {
      salesman_name: $("#salesman_name").val(),
      salesman_phone: $("#salesman_phone").val()
    },
    success: function success(obj) {
      if (obj.success) {
        $(tableName2).DataTable().ajax.reload(null, false);
      }

      swal({
        title: "Created!",
        text: "Salesman berhasil dibuat.",
        type: "success",
        timer: 2000
      });
      $("#salesman_name").val("");
      $("#salesman_phone").val("");
    },
    error: function error(data) {
      swal({
        title: "",
        text: data.responseJSON.message,
        type: "error",
        timer: 5000
      });
    }
  });
});

/***/ }),

/***/ 13:
/*!***********************************************************************!*\
  !*** multi ./resources/assets/js/suppliers/suppliers_data_listing.js ***!
  \***********************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\laragon\www\klinik\resources\assets\js\suppliers\suppliers_data_listing.js */"./resources/assets/js/suppliers/suppliers_data_listing.js");


/***/ })

/******/ });