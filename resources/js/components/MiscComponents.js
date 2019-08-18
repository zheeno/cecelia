import React, { Component } from 'react';
import { Link } from 'react-router-dom';
export const Loader = props => {
    return (
        <div className="col-12 p-5 align-center">
            <img className="img-responsive animated pulse infinite" src="../../img/cecelia-logo-grey-transparent.png" style={{ width: 250 }} />
            {props.text != null ?
                <p style={{ color: "#d7d7d7" }}>{props.text}</p>
                : null}
        </div>
    );
}

export const CartSlip = props => {
    return (
        <div className="container-fluid m-0 transparent">
            <div className="row pad-0">
                <div className="col-12 navbar navbar-nav m-0 shadow-none justify-content-center">
                    <h4 className="dark-grey-text h1-strong">Cart [{props.cartItems.length}]</h4>
                </div>
                <div className="col-12 p-2">
                    {props.cartItems.length == 0 ?
                        <div className="pad-tb-100 align-center">
                            <span className="fa fa-shopping-cart fa-4x grey-ic"></span>
                            <br />
                            <span className="grey-text">Your cart is empty</span>
                        </div>
                        :
                        <React.Fragment>
                            <ul className="list-group">
                                {
                                    props.cartItems.map((item, i) => {
                                        return (
                                            <div className="list-group-item p-1 transparent" style={{ borderWidth: 0, borderBottom: "1px dashed #d7d7d7" }} key={item.itemData.id}>
                                                <div className="row">
                                                    <div className="col-md-8 p-1">
                                                        <span className="h1-strong">{item.foodItem.item_name}</span>
                                                        <br />
                                                        <span className="grey-text" style={{ fontSize: "small" }}>&#8358;{item.itemData.price} &times; {item.itemData.qty + " " + item.unit.name + "(s)"}</span>
                                                        {item.itemData.tax > 0 ?
                                                            <React.Fragment>
                                                                <br />
                                                                <small className="grey-text">{(item.itemData.tax * 100) + "%"} Tax Inclusive  (&#8358;{(item.itemData.tax) * (item.itemData.price * item.itemData.qty)})</small>
                                                            </React.Fragment>
                                                            : null}
                                                    </div>
                                                    <div className="col-md-3 p-0" style={{ textAlign: "right" }}>
                                                        <strong className="black-text p-0 m-0">&#8358;{item.itemData.total}</strong><br />
                                                        <a style={{ color: "red", fontSize: 10 }} onClick={() => props.removeItem(item.itemData.id)}>Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        );
                                    })
                                }
                            </ul>
                            <div className="row">
                                <div className="col-12 p-3" style={{ textAlign: "right" }}>
                                    {props.cartData.tax > 0 ?
                                        <React.Fragment>
                                            <h3 className="h3-responsive m-0">&#8358;{props.cartData.total}</h3>
                                            <small>Total</small>
                                            <h3 className="h3-responsive m-0">&#8358;{props.cartData.tax}</h3>
                                            <small>Tax</small>
                                        </React.Fragment>
                                        : null}
                                    <h2 className="h2-responsive m-0">&#8358;{props.cartData.subTotal}</h2>
                                    <small>Sub total</small>
                                </div>
                            </div>
                        </React.Fragment>
                    }
                    <form method="GET" action="/market/checkout" style={{ alignItems: "center", textAlign: "center" }}>
                        <input type="hidden" name="q" value={props.cartData != null ? props.cartData.token : ""} required />
                        <button className="btn m-3 bg-red-orange white-text capitalize" disabled={props.isAdding || props.cartItems.length == 0 ? true : false}>
                            <span>Checkout</span>&nbsp;
                        {props.isAdding ?
                                <span className="fa fa-spinner fa-spin white-text"></span>
                                :
                                <span className="fa fa-check-circle"></span>
                            }
                        </button>
                    </form>
                </div>
            </div>
        </div>);
}
