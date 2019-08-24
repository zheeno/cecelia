import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import { Link } from 'react-router-dom';
import { Loader } from '../MiscComponents';




export default class SubCategory extends Component {
    constructor(props) {
        super(props);
        this.state = {
            isLoading: true,
            error: null,
            requestSuccess: false,
            subCategory: null,
            category: null,
            foodItems: []
        }
        this.getSubCatData = this.getSubCatData.bind(this);
    }

    componentDidMount() {
        this.getSubCatData(this.props.match.params.id);
    }

    getSubCatData(subCatId) {
        window.scrollTo(0, 0);
        if (subCatId != null) {
            this.setState({ isLoading: true });
            axios.get('/api/market/getSubCategory?id=' + subCatId).then(
                response => {
                    const data = response.data;
                    this.setState({
                        isLoading: false,
                        category: data.category,
                        subCategory: data.subCategory,
                        foodItems: data.foodItems,
                        error: null,
                        requestSuccess: true,
                    });
                }
            ).catch(errors => {
                this.setState({
                    isLoading: false,
                    category: null,
                    subCategory: null,
                    foodItems: [],
                    error: errors.message,
                    requestSuccess: false
                });
                console.log(errors);
            });
        }
    }

    render() {
        return (
            <div className="container-fluid">
                {this.state.isLoading ?
                    <Loader text={"We're getting everything ready..."} />
                    :
                    // check if request was successful
                    this.state.requestSuccess ?
                        <React.Fragment>
                            <div className="row">
                                <div className="col-12 p-3">
                                    <hh4 className="h4-responsive dark-grey-text">
                                        <Link className="dark-grey-text" to="/market" style={{ textDecoration: "none" }}>Market</Link>
                                        {" > "}
                                        <Link className="dark-grey-text" to={"/market/category/" + this.state.category.id} style={{ textDecoration: "none" }}>{this.state.category.category_name}</Link>
                                        {" > "}
                                        <span className="dark-grey-text h1-strong" style={{ textDecoration: "none" }}>{this.state.subCategory.sub_category_name}</span>
                                    </hh4>
                                </div>
                            </div>
                            <div className="row p-3">
                                {this.state.foodItems.map(function (food, i) {
                                    return (
                                        <Link to={"/market/foodItem/" + food.id} key={food.id} className="col-md-3 m-2 p-0" style={{ textDecoration: "none", color: "#555" }}>
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
                        </React.Fragment>
                        :
                        // show error message
                        <div className="row pad-tb-100">
                            <div className="col-12" style={{ textAlign: "center" }}>
                                <span className="fa fa-info-circle fa-5x grey-text"></span>
                                <p className="lead grey-text">{this.state.error}</p>
                            </div>
                        </div>
                }
            </div>
        );
    }
}

