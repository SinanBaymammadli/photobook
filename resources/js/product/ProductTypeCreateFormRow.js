import React, { Component } from "react";
import PropTypes from "prop-types";

class ProductTypeCreateFormRow extends Component {
  state = {};

  render() {
    const { deleteRow, index, isLast } = this.props;

    return (
      <tr>
        <td>
          <input type="text" className="form-control" name="name[]" required value="Qara" />
        </td>
        <td>
          <input type="text" className="form-control" name="detail[]" required value="lorem" />
        </td>
        <td>
          <input type="file" className="form-control" name="photo[]" required />
        </td>
        <td>
          <input type="number" className="form-control" name="price[]" required value="12313" />
        </td>
        <td>
          <input type="number" className="form-control" name="photo_count[]" required value="2" />
        </td>
        <td>
          {!isLast && (
            <button
              type="button"
              className="btn btn-sm btn-danger"
              onClick={() => deleteRow(index)}
            >
              <i className="far fa-trash-alt" />
              Delete
            </button>
          )}
        </td>
      </tr>
    );
  }
}

ProductTypeCreateFormRow.propTypes = {
  deleteRow: PropTypes.func.isRequired,
  index: PropTypes.string.isRequired,
  isLast: PropTypes.bool.isRequired,
};

export default ProductTypeCreateFormRow;
