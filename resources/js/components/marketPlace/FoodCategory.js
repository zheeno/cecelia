import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { Loader } from '../MiscComponents';
import Axios from 'axios';
import { Link } from 'react-router-dom';


export default class FoodCategory extends Component {
    constructor(props) {
        super(props);
        this.state = {
            isLoading: true,
            category: null,
            subCategories: [],
            error: null,
            requestSuccess: false
        };
        this.getCategory = this.getCategory.bind(this);
    }

    componentWillMount() {
        this.getCategory(this.props.match.params.id);
    }

    getCategory(catId) {
        window.scrollTo(0, 0);
        if (catId != null) {
            this.setState({ isLoading: true });
            Axios.get('/api/market/getCategory?id=' + catId).then(
                response => {
                    const data = response.data;
                    this.setState({
                        isLoading: false,
                        category: data.category,
                        subCategories: data.subCategories,
                        error: null,
                        requestSuccess: true,
                    });
                }
            ).catch(errors => {
                this.setState({
                    isLoading: false,
                    category: null,
                    subCategories: [],
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
                            <div className="row pad-0">
                                <div className="col-12 left-sided-panel p-0" style={{ backgroundSize: "cover", backgroundPosition: "center" }}>
                                    <div className="overlay mask row m-0 p-5">
                                        <div className="p-3 pad-tb-100 col-md-10">
                                            <h2 className="h1-strong white-text">
                                                {this.state.category.category_name}
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {this.state.subCategories.length > 0 ?
                                this.state.subCategories.map((subCat, i) => {
                                    return (
                                        <div key={subCat.subCategory.id} className="row">
                                            <div className="col-12 navbar bg-red-orange">
                                                <h5 className="h5-responsive h1-strong m-0 white-text">{subCat.subCategory.sub_category_name}</h5>
                                                <Link to={'/market/category/sub/' + subCat.subCategory.id} style={{ textDecoration: "none", color: "#fff" }} className="pull-right" >More</Link>
                                            </div>
                                            <div className="col-12 p-md-4">
                                                <div className="row p-0">
                                                    {subCat.foodItems.map(function (food, i) {
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
                                            </div>
                                        </div>
                                    )
                                })
                                : null}
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

