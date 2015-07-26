package snake.gui;

import java.awt.Color;
import java.awt.Dimension;
import java.awt.Graphics;
import java.awt.Graphics2D;

import javax.swing.JPanel;

import snake.core.Board;
import snake.core.Cell;

@SuppressWarnings("serial")
class SnakeBoardPanel extends JPanel {
	
	private Board board;
	
	public SnakeBoardPanel(Board board){
		this.board = board;
	}

		
	private void printBoard(Graphics g){
		Graphics2D g2d = (Graphics2D) g;
		
		Dimension size = getSize();
		int cellWidth = size.width / board.getColCount();
		int cellHeight = size.height / board.getRowCount();
		
		
		for(int i=0;i<board.getRowCount();i++){
			for(int a=0;a< board.getColCount();a++){
				
				if(board.getCellType(i,a)== Cell.CELL_TYPE_REMOTE_SNAKE_NODE){
					g2d.setColor(Color.GRAY);
					g2d.fillRect(a*cellWidth, i*cellHeight, cellWidth, cellHeight);
				}
				else if(board.getCellType(i,a)== Cell.CELL_TYPE_SNAKE_NODE){
					g2d.setColor(Color.black);
					g2d.fillRect(a*cellWidth, i*cellHeight, cellWidth, cellHeight);
				}
				
				else if(board.getCellType(i, a)==Cell.CELL_TYPE_FOOD){
					g2d.setColor(Color.red);
					g2d.fillOval(a*cellWidth, i*cellHeight, cellWidth, cellHeight);
				}
				
			}
		}
	}
	@Override
	public void paintComponent(Graphics g) {

		super.paintComponent(g);
		printBoard(g);
	}
}