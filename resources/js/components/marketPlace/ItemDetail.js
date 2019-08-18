import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import Axios from 'axios';
import { Loader } from '../MiscComponents';
import { Link } from 'react-router-dom';


export default class ItemDetail extends Component {
    constructor(props) {
        super(props);
        this.state = {
            isLoading: true,
            quantity: 1,
            foodItem: {},
            addedToCart: false,
            itemCartId: null,
            itemCartQty: 1,
            total_WOT: 0, //total without tax
            total_WT: 0, //total with tax
            relatedItems: []
        };
        this.handleQTYChange = this.handleQTYChange.bind(this);
        this.calcTotal = this.calcTotal.bind(this);
        this.getFoodItem = this.getFoodItem.bind(this);
    }

    componentDidMount() {
        this.getFoodItem(this.props.match.params.id);
    }

    getFoodItem(itemId) {
        window.scrollTo(0, 0);
        const cartToken = localStorage.getItem("cartToken");
        if (itemId != null) {
            this.setState({ isLoading: true });
            Axios.get('/api/market/getFoodItem?id=' + itemId + "&_token=" + cartToken).then(
                response => {
                    const data = response.data;
                    this.setState({
                        isLoading: false,
                        foodItem: data.foodItem,
                        relatedItems: data.relatedItems,
                        addedToCart: data.addedToCart,
                        itemCartId: data.itemCartId,
                        itemCartQty: data.itemCartQty
                    });
                    this.calcTotal(this.state.itemCartQty);
                    console.log("food", this.state.foodItem);
                }
            ).catch(errors => {
                console.log(errors);
            });
        }
    }

    handleQTYChange(e) {
        const _qty = e.target["value"]
        const qty = parseInt(_qty);
        this.calcTotal(qty);
    }

    calcTotal(qty) {
        if (qty < 1) {
            console.log("Invalid quantity selected");
        } else {
            const toWOT = qty * parseFloat(this.state.foodItem.item.price);
            const totWT = parseFloat(this.state.foodItem.item.tax) * toWOT;

            this.setState({ quantity: qty, total_WOT: toWOT, total_WT: totWT });
        }
    }

    render() {
        return (
            <div className="container">
                {this.state.isLoading ?
                    <Loader text={"We're preparing the item..."} />
                    :
                    <React.Fragment>
                        <div className="row">
                            <div className="col-12 p-3">
                                <span className="grey-text">
                                    <Link className="dark-grey-text" to="/market" style={{ textDecoration: "none" }}>Market</Link>
                                    <span> > </span>
                                    <Link className="dark-grey-text" to={"/market/category/" + this.state.foodItem.category.id} style={{ textDecoration: "none" }}>{this.state.foodItem.category.category_name}</Link>
                                    {this.state.foodItem.subCategory ?
                                        <React.Fragment>
                                            <span> > </span>
                                            <Link className="dark-grey-text" to={"/market/category/sub/" + this.state.foodItem.subCategory.id} style={{ textDecoration: "none" }}>{this.state.foodItem.subCategory.sub_category_name}</Link>
                                        </React.Fragment>
                                        : null}
                                    <span> > </span>
                                    <span className="dark-grey-text h1-strong" >{this.state.foodItem.item.item_name}</span>
                                </span>
                            </div>
                        </div>
                        <div className="row pad-tb-50">
                            <div className="col-md-3 mx-auto p-0">
                                <div className="card p-0">
                                    <div className="card-body p-5" style={{ height: 150, backgroundImage: `url(${this.state.foodItem.item.item_image})`, backgroundSize: "cover", backgroundRepeat: "no-repeat", backgroundPosition: "top" }}>

                                    </div>
                                    <div className="card-footer p-3 white border-0">
                                        <p className="lead h1-strong m-0">{this.state.foodItem.item.item_name}</p>
                                        {/* <strong style={{ marginTop: -8 }}>{this.state.foodItem.category.category_name}</strong><br />
                                        <small style={{ marginTop: -8 }}>{this.state.foodItem.subCategory.sub_category_name}</small> */}
                                    </div>
                                </div>
                            </div>
                            <div className="col-md-8 mx-auto p-0">
                                <div className="m-0 p-1">
                                    <ul className="list-group">
                                        <li className="list-group-item item-detail-list p-1 transparent">
                                            <strong>Item:</strong>
                                            <span style={{ marginLeft: 10 }}>{this.state.foodItem.item.item_name}</span>
                                        </li>
                                        <li className="list-group-item item-detail-list p-1 transparent">
                                            <strong>Category:</strong>
                                            <span style={{ marginLeft: 10 }}>{this.state.foodItem.category.category_name}</span>
                                        </li>
                                        <li className="list-group-item item-detail-list p-1 transparent">
                                            <strong>Subcategory:</strong>
                                            <span style={{ marginLeft: 10 }}>{this.state.foodItem.subCategory.sub_category_name}</span>
                                        </li>
                                        <li className="list-group-item item-detail-list p-1 transparent">
                                            <strong>Description:</strong>
                                            <span style={{ marginLeft: 10 }}>{this.state.foodItem.item.description}</span>
                                        </li>
                                        <li className="list-group-item item-detail-list p-1 transparent">
                                            <strong>Price <small>(Tax Exclusive)</small>:</strong>
                                            <span style={{ marginLeft: 10 }}>&#8358;{this.state.foodItem.item.price}</span>
                                        </li>
                                        <li className="list-group-item item-detail-list p-1 transparent">
                                            <strong>Quantity <small>(Per {this.state.foodItem.measure.name})</small>:</strong>
                                            <input className="border-0 p-1 transparent w-25" style={{ marginLeft: 10 }} type={"number"} value={this.state.quantity} onChange={this.handleQTYChange} />
                                        </li>
                                    </ul>
                                </div>
                                <div className="row p-3">
                                    <div className="col-md-5 ml-auto border-bottom">
                                        <h3 className="h3-responsive m-0 float-right">&#8358;{this.state.total_WOT}</h3>
                                        <small>Total</small>
                                    </div>
                                </div>

                                {parseFloat(this.state.foodItem.item.tax) > 0 ?
                                    <React.Fragment>
                                        <div className="row p-3 pad-top-0">
                                            <div className="col-md-5 ml-auto border-bottom">
                                                <h3 className="h3-responsive m-0 float-right">&#8358;{this.state.total_WT}</h3>
                                                <small>Tax ({parseFloat(this.state.foodItem.item.tax) * 100}%)</small>
                                            </div>
                                        </div>
                                        <div className="row p-3 pad-top-0">
                                            <div className="col-md-5 ml-auto border-bottom">
                                                <h3 className="h3-responsive m-0 float-right">&#8358;{this.state.total_WT + this.state.total_WOT}</h3>
                                                <small>Sub Total</small>
                                            </div>
                                        </div>
                                    </React.Fragment>
                                    : null}

                                <div className="row p-3 pad-top-0">
                                    <div className="col-md-9 ml-auto" style={{ textAlign: "right" }}>
                                        {this.state.addedToCart ?
                                            <React.Fragment>
                                                <span className="green-text">
                                                    <span className="fa fa-shopping-cart"></span>
                                                    &nbsp;Item already in cart
                                                </span>
                                                <br />
                                            </React.Fragment>
                                            : null}
                                        <button onClick={() => { this.props.addItem({ item_id: this.state.foodItem.item.id, qty: this.state.quantity }) }} type="button" className="btn bg-red-orange m-0 white-text capitalize" disabled={this.state.quantity == 0 || this.props.isAdding}>
                                            {this.props.isAdding ?
                                                <span className="fa fa-spinner fa-spin white-text"></span>
                                                :
                                                <span className="fa fa-cart-plus"></span>
                                            }
                                            &nbsp;
                                            {this.state.addedToCart ?
                                                <span>Update Cart</span>
                                                :
                                                <span>Add to cart</span>
                                            }
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {/* related food items */}
                        {this.state.relatedItems.length > 0 ?
                            <div className="row pad-tb-50">
                                <div className="col-12">
                                    <h3 className="m-0 h1-strong">Related Products</h3>
                                </div>
                                <div className="col-12">
                                    <div className="row p-3">
                                        {this.state.relatedItems.map((food, i, ) => {
                                            return (
                                                <Link to={"/market/foodItem/" + food.id} key={food.id} onClick={() => { this.getFoodItem(food.id) }} className="col-md-3 m-2 p-0" style={{ textDecoration: "none", color: "#555" }}>
                                                    <div className="card p-0">
                                                        <div className="card-body p-5" style={{ height: 150, backgroundImage: `url(${food.item_image})`, backgroundSize: "cover", backgroundRepeat: "no-repeat", backgroundPosition: "top" }}>

                                                        </div>
                                                        <div className="card-footer p-3 white border-0">
                                                            <p className="lead h1-strong m-0">{food.item_name}</p>
                                                        </div>
                                                    </div>
                                                </Link>)
                                        })
                                        }
                                    </div>
                                </div>
                            </div>
                            : null}
                    </React.Fragment>
                }
            </div>
        );
    }
}

