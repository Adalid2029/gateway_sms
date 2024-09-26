let modalId;

function setModalParameters(modal, size, onEscape, backdrop, data, isDraggable = true) {
    modalId = `#${modal._element.id}`;
    const modalBody = document.querySelector(`${modalId}-body`);
    modal._dialog.classList.add(size);

    if (data.view) {
        modalBody.innerHTML = data.view;
    }
    modal._config.backdrop = backdrop;
    modal._config.keyboard = onEscape;

    document.querySelectorAll('[data-bs-dismiss="modal"]').forEach(button => {
        button.addEventListener("click", () => modal.hide());
    });

    if (isDraggable) {
        makeDraggable();
    }

    modal.show();
    initializeAfterViewLoad();
}

function makeDraggable() {
    document.querySelectorAll(".modal-dialog").forEach(modalDialog => {
        modalDialog.style.cursor = "move";
        let isDragged = false;
        let currentX, currentY, initialX, initialY;
        let xOffset = 0, yOffset = 0;

        const dragStart = (e) => {
            if (["INPUT", "TEXTAREA", "SELECT", "SPAN"].includes(e.target.tagName) ||
                e.target.classList.contains("select2")) return;

            initialX = e.clientX - xOffset;
            initialY = e.clientY - yOffset;
            isDragged = true;
        };

        const dragEnd = () => isDragged = false;

        const drag = (e) => {
            if (!isDragged) return;
            e.preventDefault();
            currentX = e.clientX - initialX;
            currentY = e.clientY - initialY;
            xOffset = currentX;
            yOffset = currentY;
            modalDialog.style.transform = `translate3d(${currentX}px, ${currentY}px, 0)`;
        };

        modalDialog.addEventListener("mousedown", dragStart);
        modalDialog.addEventListener("mouseup", dragEnd);
        modalDialog.addEventListener("mouseleave", dragEnd);
        modalDialog.addEventListener("mousemove", drag);
    });
}

function getDataTableLanguage() {
    return {
        lengthMenu: "Show _MENU_ entries per page",
        zeroRecords: "No matching records found",
        info: "Showing _START_ to _END_ of _TOTAL_ entries",
        infoEmpty: "No records available",
        infoFiltered: "(filtered from _MAX_ total records)",
        search: "Search:",
        paginate: {
            first: "First",
            last: "Last",
            next: "Next",
            previous: "Previous",
        },
        processing: "Processing...",
        loadingRecords: "Loading...",
        emptyTable: "No data available in table",
        aria: {
            sortAscending: ": activate to sort column ascending",
            sortDescending: ": activate to sort column descending",
        },
        buttons: {
            copy: "Copy",
            colvis: "Column visibility",
        },
    };
}

function getDataTableLengthMenu() {
    return [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]];
}

function initializeAfterViewLoad() {
    $('[data-bs-toggle="tooltip"]').tooltip();

    $('[data-control="select2"]').each(function () {
        const $select = $(this);
        const hideSearch = $select.data('hide-search');

        const select2Options = {
            language: {
                noResults: () => "No results found",
                inputTooShort: () => "Please enter more characters",
                searching: () => "Searching...",
                errorLoading: () => "Unable to load results"
            },
            dropdownParent: $(`${modalId}-body`),
            allowClear: true,
            width: "100%"
        };

        if (hideSearch === true || hideSearch === "true") {
            select2Options.minimumResultsForSearch = Infinity;
        }

        $select.select2(select2Options);
    });

    loadSpanishLocale();
    $('[data-control="date"]').flatpickr({
        dateFormat: "Y-m-d",
        locale: "en",
    });
}

function loadSpanishLocale() {
    (function (global, factory) {
        typeof exports === "object" && typeof module !== "undefined"
            ? factory(exports)
            : typeof define === "function" && define.amd
                ? define(["exports"], factory)
                : ((global =
                    typeof globalThis !== "undefined" ? globalThis : global || self),
                    factory((global.es = {})));
    })(this, function (exports) {
        "use strict";

        var fp =
            typeof window !== "undefined" && window.flatpickr !== undefined
                ? window.flatpickr
                : {
                    l10ns: {},
                };
        var Spanish = {
            weekdays: {
                shorthand: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
                longhand: [
                    "Domingo",
                    "Lunes",
                    "Martes",
                    "Miércoles",
                    "Jueves",
                    "Viernes",
                    "Sábado",
                ],
            },
            months: {
                shorthand: [
                    "Ene",
                    "Feb",
                    "Mar",
                    "Abr",
                    "May",
                    "Jun",
                    "Jul",
                    "Ago",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dic",
                ],
                longhand: [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre",
                ],
            },
            ordinal: function () {
                return "º";
            },
            firstDayOfWeek: 1,
            rangeSeparator: " a ",
            time_24hr: true,
        };
        fp.l10ns.es = Spanish;
        var es = fp.l10ns;

        exports.Spanish = Spanish;
        exports.default = es;

        Object.defineProperty(exports, "__esModule", { value: true });
    });
}

function getSpanishDatePickerLocale() {
    return {
        format: "MM/DD/YYYY",
        applyLabel: "Apply",
        cancelLabel: "Cancel",
        fromLabel: "From",
        toLabel: "To",
        customRangeLabel: "Custom",
        daysOfWeek: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
        monthNames: [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ],
        firstDay: 0,
    };
}

function handleModalCancel(modal, cancelButton, form) {
    cancelButton.addEventListener("click", function (e) {
        e.preventDefault();
        Swal.fire({
            text: "Are you sure you want to cancel?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, cancel!",
            cancelButtonText: "No, return",
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-active-light",
            },
        }).then(function (result) {
            if (result.value) {
                form.reset();
                modal.hide();
            } else if (result.dismiss === "cancel") {
                Swal.fire({
                    text: "Your form has not been cancelled!",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary",
                    },
                });
            }
        });
    });
}

function BASE_URL(url) {
    return window.BASE_URL + url;
}

class Toast {
    static error(message, title = 'Error') {
        this._showToast('error', title, message);
    }

    static success(message, title = 'Success') {
        this._showToast('success', title, message);
    }

    static warning(message, title = 'Warning') {
        this._showToast('warning', title, message);
    }

    static info(message, title = 'Information') {
        this._showToast('info', title, message);
    }

    static _showToast(icon, title, message) {
        Swal.fire({
            icon: icon,
            title: title,
            html: message,
            confirmButtonText: "Continue",
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-light",
            },
            buttonsStyling: false,
        });
    }

    static mixin() {
        return Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.stopTimer);
                toast.addEventListener("mouseleave", Swal.resumeTimer);
            },
        });
    }
}

export {
    setModalParameters,
    getDataTableLanguage,
    getDataTableLengthMenu,
    handleModalCancel,
    BASE_URL,
    getSpanishDatePickerLocale,
    Toast,
};