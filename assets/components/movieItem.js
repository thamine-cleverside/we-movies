import React from 'react';
import { CCard, CRow, CCol, CCardImage, CCardBody, CCardTitle, CCardText, CButton, CModal, CModalHeader, CModalBody, CModalTitle } from '@coreui/react'
import MovieRating from "./movieRating";

export default class MovieItem extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            detailVisible: false,
        };
    }

    render() {
        const detailVisible = this.state.detailVisible;
        return (
            <div>
                <CCard className="mb-3">
                    <CRow className="g-0">
                        <CCol md={4}>
                            <CCardImage src={this.props.item.cover} />
                        </CCol>
                        <CCol md={8}>
                            <CCardBody>
                                <CCardTitle>{this.props.item.title}</CCardTitle>
                                <MovieRating ratingAverage={this.props.item.ratingAverage} ratingNumber={this.props.item.ratingNumber}/>
                                <CCardText>
                                    {this.props.item.year}
                                </CCardText>
                                <CCardText>
                                    {this.props.item.description}
                                </CCardText>
                                <CButton onClick={() => this.setState({detailVisible: true})}>Lire le detail</CButton>
                            </CCardBody>
                        </CCol>
                    </CRow>
                </CCard>
                <CModal size="xl" visible={detailVisible} onClose={() => this.setState({detailVisible: false})}>
                    <CModalHeader>
                    </CModalHeader>
                    <CModalBody>
                        <video controls width="100%">
                            <source src={this.props.item.trailer} type="video/mp4"/>
                        </video>
                        <CModalTitle>{this.props.item.title}</CModalTitle>
                        <MovieRating ratingAverage={this.props.item.ratingAverage} ratingNumber={this.props.item.ratingNumber}/>
                        <p>
                            {this.props.item.description}
                        </p>
                    </CModalBody>
                </CModal>
            </div>
        )
    }
}
