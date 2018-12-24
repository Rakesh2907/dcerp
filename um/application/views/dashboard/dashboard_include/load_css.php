<?php
	$seg1 = $this->uri->segment(1);
	$seg2 = $this->uri->segment(2);
?>
<style>
@media (min-width: 768px) {
    .modal-xl {
        width: 90%;
        max-width: 1200px;
    }
}

@media (max-width: 950px) {
    .box-body-content-table {
        overflow-x: scroll
    }
}

.brdr-t {
    border-top: 1px solid #f4f4f4;
    margin-top: 10px;
}

.brdr-r{
    border-right: 1px solid #f4f4f4;
    margin-right: 10px;
}

.brdr-b{
    border-bottom: 1px solid #f4f4f4;
    margin-bottom: 10px;
}

.brdr-l {
    border-left: 1px solid #f4f4f4;
    margin-left: 10px;
}

.whirl:after {
    border-top-color: #5d9cec;
}

.alert {
    position: absolute;
    top: 0px;
    left: 25%;
    right: 25%;
    padding: 10px;
    opacity: 0.9;
    z-index: 9;
}

 label.drug_fields{
    margin-right: 10px;
}

.multiselect-container{
    max-height: 180px;
    overflow-y: scroll;
    width: 100% !important;
}

.multiselect-native-select > .btn-group{
    width: 100% !important;
}

input[type=number]::-webkit-outer-spin-button,
input[type=number]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0;
}

input[type=number] {
    -moz-appearance:textfield;
}

.noselect {
    -webkit-touch-callout: none; /* iOS Safari */
    -webkit-user-select: none; /* Safari */
    -khtml-user-select: none; /* Konqueror HTML */
    -moz-user-select: none; /* Firefox */
    -ms-user-select: none; /* Internet Explorer/Edge */
    user-select: none; /* Non-prefixed version, currently supported by Chrome and Opera */
}

.file-block{
    border: solid 1px #97a0b3;
    width: 125px;
    padding: 5px;
    position: relative;
    float: left;
    margin: 15px 10px 0px 0px;
    text-align: center;
    overflow: hidden;
    text-overflow: ellipsis;
}

<?php if($seg1 == 'patient' && $seg2 == 'details'):?>
/*#image {
    transform-origin: top left; /* IE 10+, Firefox, etc. *
    -webkit-transform-origin: top left; /* Chrome *
    -ms-transform-origin: top left; /* IE 9 *
}*/
.rotate90 {
    transform: rotate(90deg) translateY(0%) translateX(22%);
    -webkit-transform: rotate(90deg) translateY(0%) translateX(22%);
    -ms-transform: rotate(90deg) translateY(0%) translateX(22%);
}
.rotate180 {
    transform: rotate(180deg) translate(0%,0%);
    -webkit-transform: rotate(180deg) translate(0%,0%);
    -ms-transform: rotate(180deg) translateX(0%,0%);
}
.rotate270 {
    transform: rotate(270deg) translateY(0%) translateX(-23%);
    -webkit-transform: rotate(270deg) translateY(0%) translateX(-23%);
    -ms-transform: rotate(270deg) translateY(0%) translateX(-23%);
}
<?php endif;?>

</style>