import React, { Component } from "react";
import ReactDOM from "react-dom";
import uuid from "uuid/v1";

import ProductTypeCreateFormRow from "./ProductTypeCreateFormRow";

class ProductTypeCreateForm extends Component {
  state = {
    rows: [uuid()],
  };

  addRow = () => {
    this.setState(prevState => ({
      rows: [...prevState.rows, uuid()],
    }));
  };

  deleteRow = index => {
    this.setState(prevState => ({
      rows: prevState.rows.filter(row => row !== index),
    }));
  };

  render() {
    const { rows } = this.state;

    return (
      <div>
        <div className="mb-3 d-flex justify-content-between align-items-center">
          <h4>Product types</h4>
          <button type="button" className="btn btn-sm btn-primary" onClick={this.addRow}>
            <i className="fas fa-plus" />
            Add
          </button>
        </div>

        <table className="table">
          <thead>
            <tr>
              <th scope="col">Name</th>
              <th scope="col">Detail</th>
              <th scope="col">Photo</th>
              <th scope="col">Price</th>
              <th scope="col">Photo count</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            {rows.map(row => (
              <ProductTypeCreateFormRow
                key={row}
                deleteRow={this.deleteRow}
                index={row}
                isLast={rows.length === 1}
              />
            ))}
          </tbody>
        </table>
      </div>
    );
  }
}

const element = document.getElementById("product-type-create-form");

if (element) {
  ReactDOM.render(<ProductTypeCreateForm />, element);
}
