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
/******/ 	return __webpack_require__(__webpack_require__.s = 9);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/product_categories/product_categories.js":
/*!**********************************************************************!*\
  !*** ./resources/assets/js/product_categories/product_categories.js ***!
  \**********************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var tableName = "#categoriesTbl";
var tbl = $(tableName).DataTable({
  processing: true,
  serverSide: true,
  order: [[0, "asc"]],
  ajax: {
    url: categoriesUrl
  },
  columnDefs: [{
    targets: [1],
    orderable: false,
    className: "text-center",
    width: "5%"
  }, {
    targets: "_all",
    defaultContent: "N/A"
  }],
  columns: [{
    data: "category_name",
    name: "category_name"
  }, {
    data: function data(row) {
      var data = [{
        id: row.id
      }];
      return prepareTemplateRender("#productCategoryActionTemplate", data);
    },
    name: "id"
  }]
});
$(document).on("click", ".edit-btn", function (event) {
  if (ajaxCallIsRunning) {
    return;
  }

  ajaxCallInProgress();
  var categoryId = $(event.currentTarget).data("id");
  renderData(categoryId);
});
$(document).on("click", ".delete-btn", function (event) {
  var categoryId = $(event.currentTarget).data("id");
  deleteItem(categoriesUrl + "/" + categoryId, "#categoriesTbl", "Data Kategori");
});

window.renderData = function (id) {
  $.ajax({
    url: categoriesUrl + "/" + id + "/edit",
    type: "GET",
    success: function success(result) {
      if (result.success) {
        var category = result.data;
        $("#categoryId").val(category.id);
        $("#category_name_udpate").val(category.category_name);
        $("#editModal").modal("show");
        ajaxCallCompleted();
      }
    },
    error: function error(result) {
      manageAjaxErrors(result);
    }
  });
};

$(document).on("submit", "#addNewForm", function (event) {
  event.preventDefault();
  var loadingButton = jQuery(this).find("#btnSave");
  loadingButton.button("loading");
  $.ajax({
    url: categoryCreateUrl,
    type: "POST",
    data: $(this).serialize(),
    success: function success(result) {
      if (result.success) {
        displaySuccessMessage(result.message);
        $("#addModal").modal("hide");
        $("#categoriesTbl").DataTable().ajax.reload(null, true);
      }
    },
    error: function error(result) {
      printErrorMessage("#validationErrorsBox", result);
    },
    complete: function complete() {
      loadingButton.button("reset");
    }
  });
});
$(document).on("submit", "#editForm", function (event) {
  event.preventDefault();
  var loadingButton = jQuery(this).find("#btnEditSave");
  loadingButton.button("loading");
  var id = $("#categoryId").val();
  $.ajax({
    url: categoriesUrl + "/" + id,
    type: "put",
    data: $(this).serialize(),
    success: function success(result) {
      if (result.success) {
        displaySuccessMessage(result.message);
        $("#editModal").modal("hide");
        $("#categoriesTbl").DataTable().ajax.reload(null, true);
      }
    },
    error: function error(result) {
      UnprocessableInputError(result);
    },
    complete: function complete() {
      loadingButton.button("reset");
    }
  });
});
$("#addModal").on("hidden.bs.modal", function () {
  resetModalForm("#addNewForm", "#validationErrorsBox");
});
$("#editModal").on("hidden.bs.modal", function () {
  resetModalForm("#editForm", "#editValidationErrorsBox");
});

/***/ }),

/***/ 9:
/*!****************************************************************************!*\
  !*** multi ./resources/assets/js/product_categories/product_categories.js ***!
  \****************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! E:\projects\klinik\resources\assets\js\product_categories\product_categories.js */"./resources/assets/js/product_categories/product_categories.js");


/***/ })

/******/ });