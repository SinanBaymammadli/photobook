import React, { Component } from "react";
import ReactDOM from "react-dom";

import ProductTypesFormItem from "./ProductTypesFormItem";

class ProductTypesForm extends Component {
  componentDidMount = () => {};

  render() {
    return (
      <div>
        ProductTypesForm
        <ProductTypesFormItem />
      </div>
    );
  }
}

const element = document.getElementById("product-types-form");

if (element) {
  ReactDOM.render(<ProductTypesForm />, element);
}
