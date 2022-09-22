import React from 'react';
import { CFormCheck } from '@coreui/react'

export default class MovieFilter extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            genders: [],
            selectedGenders: []
        }
        this.getGenders()
    }

    handleInputChange(id) {
        const selectedGenders = this.state.selectedGenders;
        const findIdx = selectedGenders.indexOf(id);
        if (findIdx > -1) {
            selectedGenders.splice(findIdx, 1);
        } else {
            selectedGenders.push(id);
        }

        this.setState({
            selectedGenders: selectedGenders
        })

        this.props.handler({genders: this.state.selectedGenders})
    }

    async getGenders() {
        const response = await fetch(this.props.gendersUrl)
        const data = await response.json()

        this.setState({
            genders: await data['hydra:member']
        })
    }

    render() {
        const selectedGenders = this.state.selectedGenders;
        return (
            <div>
                <h3>Filtre</h3>
                {this.state.genders.map((item, index) => (
                    <CFormCheck id={item.title} key={item.id} name={item.id} label={item.title} checked={selectedGenders.includes(item.id)} onChange={() => this.handleInputChange(item.id)}/>
                ))}
            </div>
        )
    }
}
