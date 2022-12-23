import React, { Component } from 'react'
import {
    Form,
    Modal
} from 'react-bootstrap'
import { Editor } from '@tinymce/tinymce-react';

var Globale;
var GlobleI;

const data="<p>Jogging or running is a popular form of physical activity. About one in five Australians try running (or jogging) at some stage in their life. Running is an appealing exercise because it doesn't cost a lot to take part and you can run at any time that suits you. Some runners choose to participate in fun runs, athletics races or marathons. If you are interested in competing with other runners, contact your local running club.</p>";

export class MyEditor extends Component {
    
    state={
        temp:3,
        rep_pen:2,
        k:2,
        n:2,
        temp_n:2,
        requestGoing:false,
        result:[],
        modalShow:false
    }

    handleEditorChange = (e) => {
        console.log(
          'Content was updated:',
          e.target.getContent({format : 'text'})
        );
      }
    handleTab =  (e) =>  {
          if(e.code==='Tab'){
            e.preventDefault();
            if(this.state.requestGoing===false){
                Globale=e;
                var myHeaders = new Headers();
                myHeaders.append("Content-Type", "application/json");
                e.target.attributes.contenteditable.nodeValue="false";
                this.setState({requestGoing:true});
                this.setState({temp_n:this.state.n});
                var raw = JSON.stringify({"text": e.target.innerText,"size":20,"temp":parseInt(this.state.temp),"rep_pen":parseInt(this.state.rep_pen),"k":parseInt(this.state.k),"n":parseInt(this.state.n)});
                var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: raw,
                redirect: 'follow'
                };
                fetch("http://writerapi.turboanchor.com/gpt2-large", requestOptions)
                .then(response => response.json())
                .then(result => {
                    console.log(result);
                    this.setState({result:result});
                    this.setState({requestGoing:false});
                    this.setState({modalShow:true});
                    GlobleI=this;
                })
                .catch(error => alert("Failed to fetch data from API\n",'error', error));
                    this.setState({requestGoing:false});
                    e.target.attributes.contenteditable.nodeValue="true";
                return;
            }
            else
                return;
        }
      }
    

    render() {
        return (
            <div className="row pt-3">
                            <div className="col-sm-12 col-md-8">
                            <Editor
                                id="myEditor"
                                apiKey="aomhk3dk1y1no3mai7xz9fbgd26lzimwz2p7m7bkcdr2kyn2"
                                    initialValue={data}
                                init={{
                                    editor_css : "/myeditor.css",
                                    height: 500,
                                    menubar: false,
                                    branding:false,
                                    plugins: ['lists image ',
                                        'wordcount tabfocus'
                                    ],
                                    setup:(editor) => this.editor = editor,
                                    statusbar:false,
                                    resize:false,
                                    skin: 'borderless',
                                    toolbar_sticky: true,
                                    toolbar:
                                        ' bold italic underline| bullist numlist |  cut copy paste |wordcount ',
                                    toolbar_location: 'bottom',
                                    }
                                }
                                    onChange={this.handleEditorChange}
                                    onKeyDown={this.handleTab}
                                    
                                />
                            </div>
                            <div className="col-md-4">
                            <div className="card history p-3 max-w-250">
                                <Form.Group>
                                    <Form.Label>Coherence</Form.Label>
                                    <div className="slider-counter">{this.state.temp}</div>
                                    <Form.Control type="range" min="1" max="10" value={this.state.temp} className="slider my-2" onChange={e=>this.setState({temp: e.target.value})}/>
                                </Form.Group>
                                <Form.Group>
                                    <Form.Label>Creativity</Form.Label>
                                    <div className="slider-counter">{this.state.k}</div>
                                    <Form.Control type="range" min="1" max="10" value={this.state.k} className="slider my-2" onChange={e=>this.setState({k: e.target.value})}/>
                                </Form.Group>
                                <Form.Group>
                                    <Form.Label>Repetition Strictness</Form.Label>
                                    <div className="slider-counter">{this.state.rep_pen}</div>
                                    <Form.Control type="range" min="1" max="10" value={this.state.rep_pen} className="slider my-2" onChange={e=>this.setState({rep_pen: e.target.value})}/>
                                </Form.Group>
                                <Form.Group>
                                    <Form.Label>Number of Copies</Form.Label>
                                    <div className="slider-counter">{this.state.n}</div>
                                    <Form.Control type="range" min="1" max="3" value={this.state.n} className="slider my-2" onChange={e=>this.setState({n: e.target.value})}/>
                                </Form.Group>
                                <MyVerticallyCenteredModal text={this.state.result}
                                    n={this.state.temp_n}
                                    show={this.state.modalShow}
                                    onHide={() =>{
                                        this.setState({modalShow:false})
                                        GlobleI.setState({modalShow:false});
                                        Globale.target.attributes.contenteditable.nodeValue="true";
                                    }}
                                />
                            </div>
                            </div>
                        </div>
            
        )
    }
}
function MyVerticallyCenteredModal(props) {
    return (
      <Modal
        {...props}
        size="lg"
        aria-labelledby="contained-modal-title-vcenter"
      >
        <Modal.Body>
            <hr/>
            {props.text.map((item)=>
            <>
            <div  key={item} className="row">
            <button className="btn hover-effect" onClick={()=>{
                Globale.target.innerText+=item;
                Globale.target.attributes.contenteditable.nodeValue="true";
                GlobleI.setState({modalShow:false});
            }}>
                {item}
            </button>
            </div>
            <hr/>
            </>
            )}
        </Modal.Body>
      </Modal>
    );
  }

export default MyEditor
